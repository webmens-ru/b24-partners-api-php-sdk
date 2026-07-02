<?php

declare(strict_types=1);

namespace Webmens\B24PartnersApi\Tests\Unit\Requests;

use PHPUnit\Framework\TestCase;
use Webmens\B24PartnersApi\Requests\RequestItem;

final class RequestItemTest extends TestCase
{
    public function testCanBeCreated(): void
    {
        $item = new RequestItem(productId: 123456, quantity: 2);

        $this->assertSame(123456, $item->productId);
        $this->assertSame(2, $item->quantity);
    }

    public function testDefaultQuantity(): void
    {
        $item = new RequestItem(productId: 123456);

        $this->assertSame(1, $item->quantity);
    }

    public function testToArray(): void
    {
        $item = new RequestItem(productId: 123456, quantity: 3);

        $this->assertSame(['productId' => 123456, 'quantity' => 3], $item->toArray());
    }

    public function testThrowsOnZeroProductId(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('productId must be positive');

        new RequestItem(productId: 0);
    }

    public function testThrowsOnNegativeProductId(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new RequestItem(productId: -1);
    }

    public function testThrowsOnZeroQuantity(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('quantity must be positive');

        new RequestItem(productId: 1, quantity: 0);
    }
}
