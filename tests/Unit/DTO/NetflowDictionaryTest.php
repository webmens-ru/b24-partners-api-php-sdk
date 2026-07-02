<?php

declare(strict_types=1);

namespace Webmens\B24PartnersApi\Tests\Unit\DTO;

use PHPUnit\Framework\TestCase;
use Webmens\B24PartnersApi\DTO\NetflowDictionary;

final class NetflowDictionaryTest extends TestCase
{
    public function testCanBeCreatedFromArray(): void
    {
        $data = [
            'clientTypes' => ['cloud' => 'Облачный'],
            'eventTypes' => ['payment' => 'Оплата'],
            'riskTypes' => ['downgrade' => 'Понижение'],
            'forecastStatuses' => ['active' => 'Активный'],
            'forecastOutcomes' => ['positive' => 'Положительный'],
            'forecastVerdicts' => ['confirm' => 'Подтверждён'],
            'regions' => ['msk' => 'Москва'],
            'licenses' => ['B24_PRO' => 'Профессиональный'],
        ];

        $dict = new NetflowDictionary($data);

        $this->assertSame(['cloud' => 'Облачный'], $dict->clientTypes);
        $this->assertSame(['payment' => 'Оплата'], $dict->eventTypes);
        $this->assertSame(['downgrade' => 'Понижение'], $dict->riskTypes);
        $this->assertSame(['active' => 'Активный'], $dict->forecastStatuses);
        $this->assertSame(['positive' => 'Положительный'], $dict->forecastOutcomes);
        $this->assertSame(['confirm' => 'Подтверждён'], $dict->forecastVerdicts);
        $this->assertSame(['msk' => 'Москва'], $dict->regions);
        $this->assertSame(['B24_PRO' => 'Профессиональный'], $dict->licenses);
    }

    public function testEmptyData(): void
    {
        $dict = new NetflowDictionary([]);

        $this->assertSame([], $dict->clientTypes);
        $this->assertSame([], $dict->eventTypes);
        $this->assertSame([], $dict->riskTypes);
    }
}
