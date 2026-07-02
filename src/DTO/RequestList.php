<?php

declare(strict_types=1);

namespace Webmens\B24PartnersApi\DTO;

class RequestList
{
    /** @var Request[] */
    public array $items;
    public Pagination $pagination;

    public function __construct(array $data)
    {
        $this->items = array_map(
            static fn(array $item) => new Request($item),
            $data['items'] ?? []
        );
        $this->pagination = new Pagination($data['pagination'] ?? []);
    }
}
