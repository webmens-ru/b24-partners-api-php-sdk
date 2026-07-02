<?php

declare(strict_types=1);

namespace Webmens\B24PartnersApi\DTO;

class Request
{
    public int $requestId;
    public ?int $orderId;
    public string $statusCode;
    public string $statusName;
    public ?string $paymentType;
    public ?string $shortUrl;
    public ?string $paidUntil;
    public ?array $client;
    public ?array $basket;

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
