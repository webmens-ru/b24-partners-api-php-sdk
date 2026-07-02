<?php

declare(strict_types=1);

namespace Webmens\B24PartnersApi\DTO;

class NetflowAttention
{
    public readonly int $clientId;
    public readonly ?string $clientName;
    public readonly ?string $riskType;
    public readonly ?float $impact;
    public readonly ?string $forecast;

    public function __construct(array $data)
    {
        $this->clientId = $data['clientId'] ?? 0;
        $this->clientName = $data['clientName'] ?? null;
        $this->riskType = $data['riskType'] ?? null;
        $this->impact = $data['impact'] ?? null;
        $this->forecast = $data['forecast'] ?? null;
    }
}
