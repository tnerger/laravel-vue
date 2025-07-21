# Datei: Dockerfile
FROM php:8.3-fpm

# Installiere Composer und notwendige PHP-Erweiterungen
RUN apt-get update && apt-get install -y unzip zip git libicu-dev\
    && docker-php-ext-install pdo pdo_mysql intl

# bcmath installieren
RUN docker-php-ext-install bcmath

# install PostgreSQL
RUN apt-get install -y libpq-dev \
    && docker-php-ext-install pgsql pdo_pgsql

# install GD
# Für die GD-Bibliothek benötigen wir libpng-dev, libjpeg-dev und libweb
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libwebp-dev \
    && docker-php-ext-configure gd --with-jpeg --with-webp \
    && docker-php-ext-install gd
RUN echo "upload_max_filesize=20M\npost_max_size=20M" > /usr/local/etc/php/conf.d/uploads.ini
# Composer hinzufügen
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer


WORKDIR /app

COPY . /app
# COPY ./laravel-kurs/storage ./app/laravel-kurs/storage
# COPY ./laravel-kurs/vendor ./app/laravel-kurs/vendor
# RUN cd laravel && composer install