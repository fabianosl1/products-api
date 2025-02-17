FROM php:8.1-cli

RUN apt-get update && apt-get install -y git libpq-dev && docker-php-ext-install pdo_pgsql

WORKDIR /var/www

COPY ./public ./public

COPY ./src ./src

COPY ./composer.* .

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install

EXPOSE 8080

CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]
