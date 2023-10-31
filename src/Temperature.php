<?php

declare(strict_types=1);

namespace Fizz\Readings;

use DateTimeInterface;
use Ramsey\Uuid\UuidInterface;

// VO
final readonly class Temperature
{
    public function __construct(
        public int $value,
    ) {
    }

    public static function fromCelsius(float $celsius): self
    {
        return new self((int)($celsius * 100));
    }

    public function toCelsius(): float
    {
        return $this->value / 100;
    }
}
