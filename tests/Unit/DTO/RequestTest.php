<?php

declare(strict_types=1);

namespace Webmens\B24PartnersApi\Tests\Unit\DTO;

use PHPUnit\Framework\TestCase;
use Webmens\B24PartnersApi\DTO\Request;

final class RequestTest extends TestCase
{
    public function testCanBeCreatedFromArray(): void
    {
        $data = [
            'requestId' => 199504,
            'orderId' => null,
            'statusCode' => 'NEW',
            'statusName' => 'Новая заявка',
            'paymentType' => 'direct',
            'shortUrl' => 'https://example.com/pay?hash=abc',
            'paidUntil' => '2026-06-30',
            'client' => ['cloudId' => 35102638],
            'basket' => ['Лицензия Профессиональный'],
        ];

        $request = new Request($data);

        $this->assertSame(199504, $request->requestId);
        $this->assertNull($request->orderId);
        $this->assertSame('NEW', $request->statusCode);
        $this->assertSame('Новая заявка', $request->statusName);
        $this->assertSame('direct', $request->paymentType);
        $this->assertSame('https://example.com/pay?hash=abc', $request->shortUrl);
        $this->assertSame('2026-06-30', $request->paidUntil);
        $this->assertIsArray($request->client);
        $this->assertIsArray($request->basket);
    }
}
