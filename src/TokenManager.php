<?php

declare(strict_types=1);

namespace Webmens\B24PartnersApi;

class TokenManager
{
    private string $accessToken;
    private string $refreshToken;

    /** @var callable|null */
    private $onRefresh = null;

    public function __construct(
        string $accessToken,
        string $refreshToken,
        private string $clientId,
        private string $clientSecret,
    ) {
        $this->accessToken = $accessToken;
        $this->refreshToken = $refreshToken;
    }

    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }

    public function getClientId(): string
    {
        return $this->clientId;
    }

    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }

    /**
     * Set callback to persist tokens after refresh.
     *
     * @param callable $callback function(string $accessToken, string $refreshToken): void
     */
    public function onRefresh(callable $callback): void
    {
        $this->onRefresh = $callback;
    }

    public function updateTokens(string $accessToken, string $refreshToken): void
    {
        $this->accessToken = $accessToken;
        $this->refreshToken = $refreshToken;

        if ($this->onRefresh !== null) {
            ($this->onRefresh)($accessToken, $refreshToken);
        }
    }
}
