<?php

declare(strict_types=1);

namespace Webmens\B24PartnersApi\Requests;

class RequestItem
{
    public function __construct(
        public readonly int $productId,
        public readonly int $quantity = 1,
    ) {
        if ($productId <= 0) {
            throw new \InvalidArgumentException('productId must be positive');
        }
        if ($quantity <= 0) {
            throw new \InvalidArgumentException('quantity must be positive');
        }
    }

    public function toArray(): array
    {
        return [
            'productId' => $this->productId,
            'quantity' => $this->quantity,
        ];
    }
}
