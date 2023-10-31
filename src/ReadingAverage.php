<?php

declare(strict_types=1);

namespace Fizz\Readings;

use PDO;
use Ramsey\Uuid\UuidInterface;

class ReadingAverage
{
    public function __construct(
        private readonly PDO $db,
    ) {
    }

    public function __invoke(UuidInterface $sensorId): Temperature
    {
        return new Temperature(
            $this->fetchAverage($sensorId)
        );
    }

    protected function fetchAverage(UuidInterface $sensorId): int
    {
        $stmt = $this->db->prepare(
            'SELECT temperature FROM readings_average WHERE sensor_uuid = :sensorId'
        );

        $stmt->execute([
            'sensorId' => $sensorId,
        ]);

        return (int)$stmt->fetchColumn();
    }
}
