<?php

declare(strict_types=1);

namespace Webmens\B24PartnersApi\DTO;

class Client
{
    public readonly int $cloudId;
    public readonly string $portalUrl;
    public readonly string $email;
    public readonly string $editionName;
    public readonly ?string $licenseCode;
    public readonly ?int $licenseId;
    public readonly ?\DateTimeImmutable $licenseEndDate;
    public readonly ?\DateTimeImmutable $createdAt;

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
