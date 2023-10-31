<?php

declare(strict_types=1);

use Fizz\Readings\Temperature;
use PHPUnit\Framework\TestCase;

class TemperatureTest extends TestCase
{
    public function testToCelsius(): void
    {
        $sut = new Temperature(36_60);

        self::assertSame($sut->toCelsius(), 36.6);
    }

    public function testFromCelsius(): void
    {
        $sut = Temperature::fromCelsius(99.666);

        self::assertSame($sut->toCelsius(), 99.66);
    }
}
