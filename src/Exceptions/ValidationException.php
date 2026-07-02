<?php

declare(strict_types=1);

namespace Webmens\B24PartnersApi\Exceptions;

class ValidationException extends PartnerApiException
{
    /** @var array<array{field: string, reason: string}> */
    private array $errors;

    /**
     * @param array<array{field: string, reason: string}> $errors
     */
    public function __construct(string $message, int $code = 0, ?\Throwable $previous = null, array $errors = [])
    {
        parent::__construct($message, $code, $previous);
        $this->errors = $errors;
    }

    /**
     * @return array<array{field: string, reason: string}>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
