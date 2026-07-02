<?php

declare(strict_types=1);

namespace Webmens\B24PartnersApi\Tests\Unit\DTO;

use PHPUnit\Framework\TestCase;
use Webmens\B24PartnersApi\DTO\Pagination;

final class PaginationTest extends TestCase
{
    public function testDefaultValues(): void
    {
        $pagination = new Pagination([]);

        $this->assertSame(1, $pagination->page);
        $this->assertSame(50, $pagination->limit);
        $this->assertNull($pagination->totalCount);
    }

    public function testWithData(): void
    {
        $pagination = new Pagination([
            'page' => 2,
            'limit' => 100,
            'totalCount' => 250,
        ]);

        $this->assertSame(2, $pagination->page);
        $this->assertSame(100, $pagination->limit);
        $this->assertSame(250, $pagination->totalCount);
    }
}
