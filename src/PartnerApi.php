<?php

declare(strict_types=1);

namespace Webmens\B24PartnersApi;

use Webmens\B24PartnersApi\Clients\ClientsClient;
use Webmens\B24PartnersApi\Netflow\NetflowClient;
use Webmens\B24PartnersApi\Profile\ProfileClient;
use Webmens\B24PartnersApi\Requests\RequestsClient;

class PartnerApi
{
    private HttpClient $http;
    private TokenManager $tokenManager;
    private ?ProfileClient $profile = null;
    private ?ClientsClient $clients = null;
    private ?RequestsClient $requests = null;
    private ?NetflowClient $netflow = null;

    public function __construct(
        string $accessToken,
        string $refreshToken,
        string $clientId,
        string $clientSecret,
    ) {
        $this->tokenManager = new TokenManager(
            $accessToken,
            $refreshToken,
            $clientId,
            $clientSecret,
        );

        $this->http = new HttpClient($this->tokenManager);
    }

    /**
     * Set callback to persist tokens after refresh.
     *
     * @param callable $callback function(string $accessToken, string $refreshToken): void
     */
    public function onRefresh(callable $callback): void
    {
        $this->tokenManager->onRefresh($callback);
    }

    public function profile(): ProfileClient
    {
        return $this->profile ??= new ProfileClient($this->http);
    }

    public function clients(): ClientsClient
    {
        return $this->clients ??= new ClientsClient($this->http);
    }

    public function requests(): RequestsClient
    {
        return $this->requests ??= new RequestsClient($this->http);
    }

    public function netflow(): NetflowClient
    {
        return $this->netflow ??= new NetflowClient($this->http);
    }

    /**
     * Inject pre-configured HttpClient (for testing).
     */
    public static function withHttpClient(HttpClient $http): self
    {
        $instance = new self('', '', '', '');
        $instance->http = $http;

        return $instance;
    }
}
