<?php

declare(strict_types=1);

namespace Webmens\B24PartnersApi\DTO;

class NetflowSummary
{
    public readonly ?string $dateFrom;
    public readonly ?string $dateTo;
    public readonly ?float $totalAmount;
    public readonly ?int $totalClients;

    public function __construct(array $data)
    {
        $this->dateFrom = $data['dateFrom'] ?? null;
        $this->dateTo = $data['dateTo'] ?? null;
        $this->totalAmount = $data['totalAmount'] ?? null;
        $this->totalClients = $data['totalClients'] ?? null;
    }
}
