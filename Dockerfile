FROM php:7.0.8-alpine

COPY . /usr/src/gush
WORKDIR /usr/src/gush

RUN set -xe \
    && apk add --no-cache \
    git \
    openssh-client

RUN curl -s https://getcomposer.org/installer | php \
    && chmod +x composer.phar \
    && php composer.phar install --prefer-dist --optimize-autoloader --no-interaction --no-dev \
    && rm composer.phar

ENTRYPOINT ["/usr/src/gush/gush"]
