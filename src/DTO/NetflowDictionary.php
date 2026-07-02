<?php

declare(strict_types=1);

namespace Webmens\B24PartnersApi\DTO;

class NetflowDictionary
{
    /** @var array<string, string> */
    public readonly array $clientTypes;
    /** @var array<string, string> */
    public readonly array $eventTypes;
    /** @var array<string, string> */
    public readonly array $riskTypes;
    /** @var array<string, string> */
    public readonly array $forecastStatuses;
    /** @var array<string, string> */
    public readonly array $forecastOutcomes;
    /** @var array<string, string> */
    public readonly array $forecastVerdicts;
    /** @var array<string, string> */
    public readonly array $regions;
    /** @var array<string, string> */
    public readonly array $licenses;

    public function __construct(array $data)
    {
        $this->clientTypes = $data['clientTypes'] ?? [];
        $this->eventTypes = $data['eventTypes'] ?? [];
        $this->riskTypes = $data['riskTypes'] ?? [];
        $this->forecastStatuses = $data['forecastStatuses'] ?? [];
        $this->forecastOutcomes = $data['forecastOutcomes'] ?? [];
        $this->forecastVerdicts = $data['forecastVerdicts'] ?? [];
        $this->regions = $data['regions'] ?? [];
        $this->licenses = $data['licenses'] ?? [];
    }
}
