FROM php:8.1-apache

COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

RUN a2enmod rewrite

RUN apt-get update && \
    apt-get install \
    libzip-dev \
    wget \
    git \
    unzip \
    -y --no-install-recommends

RUN docker-php-ext-install zip pdo_mysql

COPY ./php.ini /usr/local/etc/php/

COPY ./install-composer.sh /var/www/

WORKDIR /var/www

RUN chmod +x /var/www/install-composer.sh \
    && /var/www/install-composer.sh \
    && rm /var/www/install-composer.sh

RUN chown -R www-data:www-data /var/www

CMD ["apache2-foreground"]
