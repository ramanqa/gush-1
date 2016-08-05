FROM php:7.0.8-alpine

RUN set -xe \
    && apk add --no-cache \
    git \
    openssh-client

RUN curl -s https://getcomposer.org/installer | php \
    && chmod +x composer.phar \
    && mv composer.phar /usr/bin/composer

RUN mkdir /root/project
WORKDIR /root/project

COPY ./src /usr/src/gush/src
COPY ./gush /usr/src/gush/gush
COPY ./composer.json /usr/src/gush/composer.json

WORKDIR /usr/src/gush

RUN COMPOSER_ALLOW_SUPERUSER=1 composer install --prefer-dist --optimize-autoloader --no-interaction --no-dev \
    && rm composer.phar \
    && rm composer.json \
    && rm composer.lock

ENTRYPOINT ["/usr/src/gush/gush"]
