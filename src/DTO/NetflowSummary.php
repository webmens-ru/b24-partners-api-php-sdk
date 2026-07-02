<?php

declare(strict_types=1);

namespace Webmens\B24PartnersApi\DTO;

class NetflowSummary
{
    public ?string $dateFrom;
    public ?string $dateTo;
    public ?float $totalAmount;
    public ?int $totalClients;

    public function __construct(array $data)
    {
        $this->dateFrom = $data['dateFrom'] ?? null;
        $this->dateTo = $data['dateTo'] ?? null;
        $this->totalAmount = $data['totalAmount'] ?? null;
        $this->totalClients = $data['totalClients'] ?? null;
    }
}
