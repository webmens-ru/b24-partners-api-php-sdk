<?php

declare(strict_types=1);

namespace Webmens\B24PartnersApi\DTO;

class Request
{
    public readonly int $requestId;
    public readonly ?int $orderId;
    public readonly string $statusCode;
    public readonly string $statusName;
    public readonly ?string $paymentType;
    public readonly ?string $shortUrl;
    public readonly ?string $paidUntil;
    public readonly ?array $client;
    public readonly ?array $basket;

    public function __construct(array $data)
    {
        $this->requestId = $data['requestId'] ?? 0;
        $this->orderId = $data['orderId'] ?? null;
        $this->statusCode = $data['statusCode'] ?? '';
        $this->statusName = $data['statusName'] ?? '';
        $this->paymentType = $data['paymentType'] ?? null;
        $this->shortUrl = $data['shortUrl'] ?? null;
        $this->paidUntil = $data['paidUntil'] ?? null;
        $this->client = $data['client'] ?? null;
        $this->basket = $data['basket'] ?? null;
    }
}
