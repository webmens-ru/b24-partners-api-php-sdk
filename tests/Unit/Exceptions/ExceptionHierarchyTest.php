<?php

declare(strict_types=1);

namespace Webmens\B24PartnersApi\Tests\Unit\Exceptions;

use PHPUnit\Framework\TestCase;
use Webmens\B24PartnersApi\Exceptions\ConflictException;
use Webmens\B24PartnersApi\Exceptions\ForbiddenException;
use Webmens\B24PartnersApi\Exceptions\NotFoundException;
use Webmens\B24PartnersApi\Exceptions\PartnerApiException;
use Webmens\B24PartnersApi\Exceptions\RequestException;
use Webmens\B24PartnersApi\Exceptions\UnauthorizedException;

final class ExceptionHierarchyTest extends TestCase
{
    /**
     * @dataProvider exceptionProvider
     */
    public function testAllExceptionsExtendBase(string $exceptionClass): void
    {
        $exception = new $exceptionClass('test', 400);

        $this->assertInstanceOf(PartnerApiException::class, $exception);
        $this->assertInstanceOf(\RuntimeException::class, $exception);
    }

    public static function exceptionProvider(): array
    {
        return [
            'UnauthorizedException' => [UnauthorizedException::class],
            'ForbiddenException' => [ForbiddenException::class],
            'NotFoundException' => [NotFoundException::class],
            'ConflictException' => [ConflictException::class],
            'RequestException' => [RequestException::class],
        ];
    }
}
