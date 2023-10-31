# EF Readings


## How to start

Clone and `docker compose up`

## Unit tests

Locally: `phpunit`

--or--

`docker run --rm -it -v $(pwd):/app -w /app jakzal/phpqa:php8.2-alpine phpunit`

## Endpoints

API#3
http://localhost:8000/api/sensors/average/4

API#4
http://localhost:8000/api/sensors/{sensor-uuid}/average
