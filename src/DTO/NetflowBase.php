<?php

declare(strict_types=1);

namespace Webmens\B24PartnersApi\DTO;

class NetflowBase
{
    public readonly ?string $date;
    public readonly ?float $totalAmount;
    public readonly ?int $totalClients;

    public function __construct(array $data)
    {
        $this->date = $data['date'] ?? null;
        $this->totalAmount = $data['totalAmount'] ?? null;
        $this->totalClients = $data['totalClients'] ?? null;
    }
}
