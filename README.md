# Readings


## How to start

Clone and `docker compose up`

## Unit tests

Locally: `phpunit`

--or--

`docker run --rm -it -v $(pwd):/app -w /app jakzal/phpqa:php8.2-alpine phpunit`
