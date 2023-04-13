FROM php:fpm

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

RUN pecl install xdebug-3.1.6

# # Composer required packages
# RUN apt-get install -y libzip-dev \
#      && docker-php-ext-install zip gd

# MySQL
RUN docker-php-ext-install pdo_mysql

EXPOSE 9000

CMD php-fpm
