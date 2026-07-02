<?php

declare(strict_types=1);

namespace Webmens\B24PartnersApi\Tests\Unit\Exceptions;

use PHPUnit\Framework\TestCase;
use Webmens\B24PartnersApi\Exceptions\PartnerApiException;
use Webmens\B24PartnersApi\Exceptions\ValidationException;

final class ValidationExceptionTest extends TestCase
{
    public function testCanBeCreatedWithErrors(): void
    {
        $errors = [
            ['field' => 'portalUrl', 'reason' => 'Portal not found'],
            ['field' => 'email', 'reason' => 'Invalid format'],
        ];

        $exception = new ValidationException('Validation failed', 422, null, $errors);

        $this->assertSame('Validation failed', $exception->getMessage());
        $this->assertSame(422, $exception->getCode());
        $this->assertSame($errors, $exception->getErrors());
    }

    public function testImplementsPartnerApiException(): void
    {
        $exception = new ValidationException('test', 422);

        $this->assertInstanceOf(PartnerApiException::class, $exception);
        $this->assertInstanceOf(\RuntimeException::class, $exception);
    }

    public function testDefaultErrors(): void
    {
        $exception = new ValidationException('test', 422);

        $this->assertSame([], $exception->getErrors());
    }
}
