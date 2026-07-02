<?php

declare(strict_types=1);

namespace Webmens\B24PartnersApi\Tests\Unit\DTO;

use PHPUnit\Framework\TestCase;
use Webmens\B24PartnersApi\DTO\Client;

final class ClientTest extends TestCase
{
    public function testCanBeCreatedFromArray(): void
    {
        $data = [
            'cloudId' => 35204048,
            'portalUrl' => 'demo.bitrix24.ru',
            'email' => 'client@example.com',
            'editionName' => 'Professional',
            'licenseCode' => 'B24_PRO',
            'licenseId' => 12345,
            'licenseEndDate' => '2026-12-31',
            'createdAt' => '2025-01-15T10:30:00+03:00',
        ];

        $client = new Client($data);

        $this->assertSame(35204048, $client->cloudId);
        $this->assertSame('demo.bitrix24.ru', $client->portalUrl);
        $this->assertSame('client@example.com', $client->email);
        $this->assertSame('Professional', $client->editionName);
        $this->assertSame('B24_PRO', $client->licenseCode);
        $this->assertSame(12345, $client->licenseId);
        $this->assertInstanceOf(\DateTimeImmutable::class, $client->licenseEndDate);
        $this->assertInstanceOf(\DateTimeImmutable::class, $client->createdAt);
    }

    public function testHandlesNullDates(): void
    {
        $data = [
            'cloudId' => 1,
            'portalUrl' => 'test.ru',
            'email' => 'a@b.com',
            'editionName' => 'Basic',
            'licenseEndDate' => null,
            'createdAt' => null,
        ];

        $client = new Client($data);

        $this->assertNull($client->licenseEndDate);
        $this->assertNull($client->createdAt);
    }

    public function testHandlesEmptyData(): void
    {
        $client = new Client([]);

        $this->assertSame(0, $client->cloudId);
        $this->assertSame('', $client->portalUrl);
        $this->assertSame('', $client->email);
        $this->assertSame('', $client->editionName);
        $this->assertNull($client->licenseCode);
        $this->assertNull($client->licenseId);
    }
}
