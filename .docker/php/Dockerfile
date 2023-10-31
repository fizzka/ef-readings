FROM php:8.2-alpine

RUN apk add --no-cache postgresql-libs postgresql-dev &&\
    docker-php-ext-install pdo_pgsql &&\
    apk del postgresql-dev

COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer
