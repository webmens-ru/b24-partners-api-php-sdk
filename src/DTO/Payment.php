<?php

declare(strict_types=1);

namespace Webmens\B24PartnersApi\DTO;

class Payment
{
    public readonly ?string $shortUrl;
    public readonly ?string $invoicePdf;
    public readonly ?string $paidUntil;
    public readonly ?string $statusCode;

    public function __construct(array $data)
    {
        $this->shortUrl = $data['shortUrl'] ?? null;
        $this->invoicePdf = $data['invoicePdf'] ?? null;
        $this->paidUntil = $data['paidUntil'] ?? null;
        $this->statusCode = $data['statusCode'] ?? null;
    }
}
