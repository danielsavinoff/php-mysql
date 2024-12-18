FROM php:8.1.31-fpm-alpine3.20

RUN apk add --no-cache gcc g++ && \
docker-php-ext-install pdo pdo_mysql