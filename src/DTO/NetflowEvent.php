<?php

declare(strict_types=1);

namespace Webmens\B24PartnersApi\DTO;

class NetflowEvent
{
    public readonly int $eventId;
    public readonly ?int $clientId;
    public readonly ?string $clientType;
    public readonly ?string $eventType;
    public readonly ?float $amount;
    public readonly ?string $date;

    public function __construct(array $data)
    {
        $this->eventId = $data['eventId'] ?? 0;
        $this->clientId = $data['clientId'] ?? null;
        $this->clientType = $data['clientType'] ?? null;
        $this->eventType = $data['eventType'] ?? null;
        $this->amount = $data['amount'] ?? null;
        $this->date = $data['date'] ?? null;
    }
}
