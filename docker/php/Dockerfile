FROM php:alpine

RUN curl -sS https://getcomposer.org/installer | php \
        && mv composer.phar /usr/local/bin/ \
        && ln -s /usr/local/bin/composer.phar /usr/local/bin/composer

RUN apk update && apk upgrade && \
    apk add --no-cache bash git openssh
