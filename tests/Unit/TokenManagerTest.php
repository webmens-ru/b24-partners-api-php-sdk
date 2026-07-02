<?php

declare(strict_types=1);

namespace Webmens\B24PartnersApi\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Webmens\B24PartnersApi\TokenManager;

final class TokenManagerTest extends TestCase
{
    public function testReturnsAccessToken(): void
    {
        $manager = new TokenManager(
            accessToken: 'initial-token',
            refreshToken: 'refresh-token',
            clientId: 'client-id',
            clientSecret: 'client-secret',
        );

        $this->assertSame('initial-token', $manager->getAccessToken());
    }

    public function testReturnsRefreshToken(): void
    {
        $manager = new TokenManager(
            accessToken: 'abc',
            refreshToken: 'def',
            clientId: 'id',
            clientSecret: 'secret',
        );

        $this->assertSame('def', $manager->getRefreshToken());
    }

    public function testReturnsClientId(): void
    {
        $manager = new TokenManager(
            accessToken: 'abc',
            refreshToken: 'def',
            clientId: 'my-client-id',
            clientSecret: 'secret',
        );

        $this->assertSame('my-client-id', $manager->getClientId());
    }

    public function testReturnsClientSecret(): void
    {
        $manager = new TokenManager(
            accessToken: 'abc',
            refreshToken: 'def',
            clientId: 'id',
            clientSecret: 'my-secret',
        );

        $this->assertSame('my-secret', $manager->getClientSecret());
    }

    public function testUpdateTokens(): void
    {
        $manager = new TokenManager(
            accessToken: 'old-access',
            refreshToken: 'old-refresh',
            clientId: 'id',
            clientSecret: 'secret',
        );

        $manager->updateTokens('new-access', 'new-refresh');

        $this->assertSame('new-access', $manager->getAccessToken());
        $this->assertSame('new-refresh', $manager->getRefreshToken());
    }
}
