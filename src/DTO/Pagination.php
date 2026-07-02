<?php

declare(strict_types=1);

namespace Webmens\B24PartnersApi\DTO;

class Pagination
{
    public int $page;
    public int $limit;
    public ?int $totalCount;

    public function __construct(array $data)
    {
        $this->page = $data['page'] ?? 1;
        $this->limit = $data['limit'] ?? 50;
        $this->totalCount = $data['totalCount'] ?? null;
    }
}
