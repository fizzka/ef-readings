<?php

declare(strict_types=1);

use Fizz\Readings\OverallAverage;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class OverallAverageTest extends TestCase
{
    public function testToCelsius(): void
    {
        /** @var OverallAverage&MockObject */
        $sut = $this->createPartialMock(OverallAverage::class, ['fetchAverage']);

        $sut->method('fetchAverage')->willReturn(42_42);

        self::assertSame($sut(42)->toCelsius(), 42.42);
    }
}
