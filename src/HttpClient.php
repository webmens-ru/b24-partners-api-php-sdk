<?php

declare(strict_types=1);

namespace Webmens\B24PartnersApi;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException as GuzzleRequestException;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use Psr\Http\Message\ResponseInterface;
use Webmens\B24PartnersApi\Exceptions\ConflictException;
use Webmens\B24PartnersApi\Exceptions\ForbiddenException;
use Webmens\B24PartnersApi\Exceptions\NotFoundException;
use Webmens\B24PartnersApi\Exceptions\PartnerApiException;
use Webmens\B24PartnersApi\Exceptions\RequestException;
use Webmens\B24PartnersApi\Exceptions\UnauthorizedException;
use Webmens\B24PartnersApi\Exceptions\ValidationException;

class HttpClient
{
    private const BASE_URL = 'https://util.1c-bitrix.ru/rest/api/';
    private const OAUTH_URL = 'https://oauth.bitrix.info/oauth/token/';

    private GuzzleClient $guzzle;
    private int $maxRetries = 3;

    public function __construct(
        private TokenManager $tokenManager,
        ?GuzzleClient $guzzle = null,
    ) {
        $this->guzzle = $guzzle ?? new GuzzleClient([
            'timeout' => 60,
            'connect_timeout' => 30,
        ]);
    }

    /**
     * POST request to Partner API.
     *
     * @param string $method  API method name
     * @param array  $params  Query parameters
     * @param ?array $body    JSON body (for write methods)
     * @param array  $headers Extra headers
     * @return array Decoded JSON response
     *
     * @throws PartnerApiException
     */
    public function post(
        string $method,
        array $params = [],
        ?array $body = null,
        array $headers = [],
    ): array {
        $url = self::BASE_URL . $method;

        if (!empty($params)) {
            $url .= '?' . http_build_query($params);
        }

        $headers = array_merge([
            'Authorization' => 'Bearer ' . $this->tokenManager->getAccessToken(),
            'Content-Type' => 'application/json',
        ], $headers);

        $bodyJson = $body !== null ? json_encode($body, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE) : null;

        return $this->requestWithRetry('POST', $url, $headers, $bodyJson, isRetryable: true);
    }

    /**
     * POST request to OAuth endpoint for token refresh.
     *
     * @param array $params Form-encoded parameters
     * @return array Decoded JSON response
     *
     * @throws PartnerApiException
     */
    public function postOAuth(array $params): array
    {
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
        ];

        $body = http_build_query($params);

        return $this->requestWithRetry('POST', self::OAUTH_URL, $headers, $body, isRetryable: false);
    }

    /**
     * Refresh access token via OAuth.
     *
     * @throws UnauthorizedException If refresh fails
     */
    public function refreshAccessToken(): void
    {
        $result = $this->postOAuth([
            'grant_type' => 'refresh_token',
            'client_id' => $this->tokenManager->getClientId(),
            'client_secret' => $this->tokenManager->getClientSecret(),
            'refresh_token' => $this->tokenManager->getRefreshToken(),
        ]);

        $this->tokenManager->updateTokens(
            $result['access_token'],
            $result['refresh_token'] ?? $this->tokenManager->getRefreshToken(),
        );
    }

    /**
     * Execute request with retry logic.
     *
     * @throws PartnerApiException
     */
    private function requestWithRetry(
        string $method,
        string $url,
        array $headers,
        ?string $body,
        bool $isRetryable,
        int $attempt = 0,
    ): array {
        try {
            $request = new GuzzleRequest($method, $url, $headers, $body);
            $response = $this->guzzle->send($request);

            return $this->parseResponse($response);
        } catch (GuzzleRequestException $e) {
            if (!$e->hasResponse()) {
                throw new RequestException(
                    'HTTP request failed: ' . $e->getMessage(),
                    0,
                    $e,
                );
            }

            $response = $e->getResponse();

            if ($response === null) {
                throw new RequestException(
                    'HTTP request failed: ' . $e->getMessage(),
                    0,
                    $e,
                );
            }

            $statusCode = $response->getStatusCode();

            // 401 — try refresh + retry (once)
            if ($statusCode === 401 && $isRetryable && $attempt === 0) {
                $this->refreshAccessToken();

                // Update Authorization header with new token
                $headers['Authorization'] = 'Bearer ' . $this->tokenManager->getAccessToken();

                return $this->requestWithRetry($method, $url, $headers, $body, isRetryable: false, attempt: 1);
            }

            // 429 — retry with backoff
            if ($statusCode === 429 && $attempt < $this->maxRetries) {
                $delay = (int) pow(2, $attempt); // 1s, 2s, 4s
                sleep($delay);

                return $this->requestWithRetry($method, $url, $headers, $body, $isRetryable, $attempt + 1);
            }

            // 5xx — retry (once)
            if ($statusCode >= 500 && $attempt < 2) {
                sleep(1);

                return $this->requestWithRetry($method, $url, $headers, $body, $isRetryable, $attempt + 1);
            }

            $this->throwException($response);
        } catch (GuzzleException $e) {
            throw new RequestException(
                'HTTP request failed: ' . $e->getMessage(),
                0,
                $e,
            );
        }
    }

    /**
     * Parse successful response.
     */
    private function parseResponse(ResponseInterface $response): array
    {
        $body = (string) $response->getBody();
        $data = json_decode($body, true, 512, JSON_THROW_ON_ERROR);

        if (!is_array($data)) {
            throw new PartnerApiException('Invalid response format');
        }

        return $data;
    }

    /**
     * Throw appropriate exception based on HTTP status code.
     *
     * @return never
     * @throws PartnerApiException
     */
    private function throwException(ResponseInterface $response)
    {
        $statusCode = $response->getStatusCode();
        $body = (string) $response->getBody();
        $data = json_decode($body, true) ?: [];
        $message = $data['error']['message'] ?? $data['message'] ?? 'Unknown error';
        $details = $data['error']['details'] ?? [];

        // Include raw response in message for debugging
        if ($message === 'Unknown error' && !empty($body)) {
            $message = 'Unknown error. Response: ' . substr($body, 0, 500);
        }

        throw match (true) {
            $statusCode === 401 => new UnauthorizedException($message, $statusCode),
            $statusCode === 403 => new ForbiddenException($message, $statusCode),
            $statusCode === 404 => new NotFoundException($message, $statusCode),
            $statusCode === 409 => new ConflictException($message, $statusCode),
            $statusCode === 422 => new ValidationException($message, $statusCode, errors: $details),
            default => new PartnerApiException($message, $statusCode),
        };
    }
}
