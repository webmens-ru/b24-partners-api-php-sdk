<?php

declare(strict_types=1);

namespace Webmens\B24PartnersApi\DTO;

class ClientList
{
    /** @var Client[] */
    public readonly array $items;
    public readonly Pagination $pagination;

    public function __construct(array $data)
    {
        $this->items = array_map(
            static fn(array $item) => new Client($item),
            $data['items'] ?? []
        );
        $this->pagination = new Pagination($data['pagination'] ?? []);
    }
}
