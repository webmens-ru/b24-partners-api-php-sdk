<?php

declare(strict_types=1);

namespace Webmens\B24PartnersApi\DTO;

class NetflowBase
{
    public ?string $date;
    public ?float $totalAmount;
    public ?int $totalClients;

    public function __construct(array $data)
    {
        $this->date = $data['date'] ?? null;
        $this->totalAmount = $data['totalAmount'] ?? null;
        $this->totalClients = $data['totalClients'] ?? null;
    }
}
