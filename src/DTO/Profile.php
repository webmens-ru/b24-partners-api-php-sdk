<?php

declare(strict_types=1);

namespace Webmens\B24PartnersApi\DTO;

class Profile
{
    public readonly int $partnerId;
    public readonly string $name;
    public readonly ?string $inn;
    public readonly ?string $email;
    public readonly ?string $phone;

    public function __construct(array $data)
    {
        $this->partnerId = $data['partnerId'] ?? 0;
        $this->name = $data['name'] ?? '';
        $this->inn = $data['inn'] ?? null;
        $this->email = $data['email'] ?? null;
        $this->phone = $data['phone'] ?? null;
    }
}
