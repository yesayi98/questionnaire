FROM php:8.2-fpm

ARG UID=1000
ARG GID=1000
RUN groupadd -f -g $GID www && \
    useradd -u $UID -g $GID -m www

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libicu-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libpq-dev\
    zip \
    && docker-php-ext-install \
    intl \
    mbstring \
    opcache \
    pdo \
    pdo_pgsql \
    pdo_mysql \
    zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

EXPOSE 9000
CMD ["php-fpm", "--nodaemonize"]
