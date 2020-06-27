# starting image
FROM php:5.6-fpm

# set workdir and volume

WORKDIR /var/www/html
VOLUME /var/www/html

# updates
RUN apt-get update \
  && apt-get autoremove -y

# add local user
RUN useradd -u 1000 local

# install php extensions
RUN docker-php-ext-install bcmath \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install ctype\
    && docker-php-ext-install json \
    && docker-php-ext-install tokenizer \
    && docker-php-ext-install mbstring \
    && docker-php-ext-install mysqli

# copy php custom ini file
COPY ./custom.ini /usr/local/etc/php/conf.d/custom.ini
