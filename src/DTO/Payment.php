<?php

declare(strict_types=1);

namespace Webmens\B24PartnersApi\DTO;

class Payment
{
    public ?string $shortUrl;
    public ?string $invoicePdf;
    public ?string $paidUntil;
    public ?string $statusCode;

    public function __construct(array $data)
    {
        $this->shortUrl = $data['shortUrl'] ?? null;
        $this->invoicePdf = $data['invoicePdf'] ?? null;
        $this->paidUntil = $data['paidUntil'] ?? null;
        $this->statusCode = $data['statusCode'] ?? null;
    }
}
