<?php

declare(strict_types=1);

namespace Fizz\Readings;

use PDO;

class OverallAverage
{
    public function __construct(
        private readonly PDO $db,
    ) {
    }

    public function __invoke(int $days): Temperature
    {
        return new Temperature(
            $this->fetchAverage($days)
        );
    }

    protected function fetchAverage(int $days): int
    {
        $interval = "{$days} DAYS";

        $stmt = $this->db->prepare(<<<SQL
            SELECT AVG(temperature)::SMALLINT temperature
            FROM (
                SELECT sensor_uuid, AVG(temperature) temperature
                FROM readings
                WHERE
                    created > NOW() - :interval::INTERVAL
                GROUP BY sensor_uuid
            )
        SQL);

        $stmt->execute([
            'interval' => $interval,
        ]);

        return (int)$stmt->fetchColumn();
    }
}
