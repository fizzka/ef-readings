<?php

declare(strict_types=1);

namespace Fizz\Readings\Functions;

use Fizz\Readings\OverallAverage;
use Fizz\Readings\ReadingAverage;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Response\JsonResponse;
use PDO;
use Psr\Http\Message\ResponseInterface;
use Ramsey\Uuid\Nonstandard\Uuid;

function overallAverage(PDO $pdo, string $days): ResponseInterface
{
    $days = (int)$days;

    $command = new OverallAverage($pdo);

    return new JsonResponse([
        'days' => $days,
        'average' => $command($days)->toCelsius(),
    ]);
}

function sensorAverage(PDO $pdo, string $sensor): ResponseInterface
{
    $sensorUuid = Uuid::fromString($sensor);

    $command = new ReadingAverage($pdo);

    return new JsonResponse([
        'sensor_uuid' => $sensorUuid,
        'average' => $command($sensorUuid)->toCelsius()
    ]);
}

// fake, not realised
// TODO
function pushReading(): ResponseInterface
{
    return new JsonResponse(null, 201);
}

// fake, not realised
// TODO
function pullReading(): ResponseInterface
{
    $csvData = [
        'reading_id' => random_int(1, 100500),
        'temperature' => random_int(0, 100500) / 100,
    ];
    return new Response(implode(',', $csvData), 201);
}
