<?php

declare(strict_types=1);

namespace Fizz\Readings\Tests\Unit;

use Fizz\Readings\ReadingAverage;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class ReadingAverageTest extends TestCase
{
    public function testToCelsius(): void
    {
        /** @var ReadingAverage&MockObject */
        $sut = $this->createPartialMock(ReadingAverage::class, ['fetchAverage']);

        $sut->method('fetchAverage')->willReturn(42_42);

        self::assertSame($sut(Uuid::fromString('cab0b571-eb0b-4f73-b461-e2b0ce7f7c47'))->toCelsius(), 42.42);
    }
}
