<?php

declare(strict_types=1);

namespace Webmens\B24PartnersApi\DTO;

class NetflowClientItem
{
    public readonly int $clientId;
    public readonly ?string $clientName;
    public readonly ?string $clientType;
    public readonly ?float $impact;

    public function __construct(array $data)
    {
        $this->clientId = $data['clientId'] ?? 0;
        $this->clientName = $data['clientName'] ?? null;
        $this->clientType = $data['clientType'] ?? null;
        $this->impact = $data['impact'] ?? null;
    }
}
