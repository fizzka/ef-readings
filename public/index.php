<?php

declare(strict_types=1);

use Laminas\Diactoros\Response\JsonResponse;
use Laminas\Diactoros\ServerRequestFactory;
use function Fizz\Readings\Functions\overallAverage;
use function Fizz\Readings\Functions\pullReading;
use function Fizz\Readings\Functions\pushReading;
use function Fizz\Readings\Functions\sensorAverage;

require '../vendor/autoload.php';

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->get('/api/sensors/average/{days:\d+}', overallAverage(...));
    $r->get('/api/sensors/{sensor:[a-z\d\-]}/average', sensorAverage(...));

    // API#1
    $r->post('/api/push', pushReading(...));
    // API#2
    $r->get('/sensor/read/{sensor_uuid:[a-z\d\-]}', pullReading(...));
    
});

$container = new DI\Container([
    'db.host' => DI\env('DB_HOST'),
    'db.name' => DI\env('DB_NAME'),
    'db.user' => DI\env('DB_USER'),
    'db.pass' => DI\env('DB_PASS'),
    'db.dsn' => DI\string('pgsql:host={db.host};dbname={db.name};user={db.user};password={db.pass}'),
    PDO::class => DI\create()->constructor(DI\get('db.dsn')),
]);

$request = ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES,
);

$routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getUri()->getPath());

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        $response = new JsonResponse(['Not found'], 404);
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        $response = new JsonResponse(['Method Not Allowed'], 405);
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        $response = $handler($container->get(PDO::class), ...$vars);
        break;
}

array_map(
    fn($header) => header($header . ': ' . $response->getHeaderLine($header)),
    array_keys($response->getHeaders())
);

echo $response->getBody();
