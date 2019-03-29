FROM php:7

RUN apt-get update -y && apt-get install -y openssl zip unzip git libzip-dev zlib1g-dev
RUN docker-php-ext-install pdo mbstring zip pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer global require hirak/prestissimo

WORKDIR /app
COPY composer.json composer.lock ./
COPY database/ ./database/
RUN composer install \
    --optimize-autoloader \
    --no-dev \
    --ignore-platform-reqs \
    --no-interaction \
    --no-scripts \
    --prefer-dist
COPY . .
RUN rm ./bootstrap/cache/* # Laravel may try to access some dev dependencies otherwise

CMD php artisan serve --host=0.0.0.0 --port=8000
EXPOSE 8000
