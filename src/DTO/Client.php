<?php

declare(strict_types=1);

namespace Webmens\B24PartnersApi\DTO;

class Client
{
    public int $cloudId;
    public string $portalUrl;
    public string $email;
    public string $editionName;
    public ?string $licenseCode;
    public ?int $licenseId;
    public ?\DateTimeImmutable $licenseEndDate;
    public ?\DateTimeImmutable $createdAt;

    public function __construct(array $data)
    {
        $this->cloudId = $data['cloudId'] ?? 0;
        $this->portalUrl = $data['portalUrl'] ?? '';
        $this->email = $data['email'] ?? '';
        $this->editionName = $data['editionName'] ?? '';
        $this->licenseCode = $data['licenseCode'] ?? null;
        $this->licenseId = $data['licenseId'] ?? null;
        $this->licenseEndDate = $this->parseDate($data['licenseEndDate'] ?? null);
        $this->createdAt = $this->parseDate($data['createdAt'] ?? null);
    }

    private function parseDate(?string $date): ?\DateTimeImmutable
    {
        if ($date === null || $date === '') {
            return null;
        }

        return new \DateTimeImmutable($date);
    }
}
