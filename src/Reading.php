<?php

declare(strict_types=1);

namespace Fizz\Readings;

use DateTimeInterface;
use Ramsey\Uuid\UuidInterface;

final readonly class Reading
{
    public function __construct(
        public UuidInterface $sensorId,
        public Temperature $temperature,
        public DateTimeInterface $created,
    ) {
    }
}
