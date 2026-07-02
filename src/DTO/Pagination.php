<?php

declare(strict_types=1);

namespace Webmens\B24PartnersApi\DTO;

class Pagination
{
    public readonly int $page;
    public readonly int $limit;
    public readonly ?int $totalCount;

    public function __construct(array $data)
    {
        $this->page = $data['page'] ?? 1;
        $this->limit = $data['limit'] ?? 50;
        $this->totalCount = $data['totalCount'] ?? null;
    }
}
