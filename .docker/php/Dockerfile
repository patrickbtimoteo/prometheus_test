FROM php:8.1-fpm

COPY usr/local/etc/php/php.ini /usr/local/etc/php/php.ini

# Arguments defined in docker-compose.yml
ARG user
ARG uid
ENV XDEBUG_VERSION='3.1.2'

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

RUN pecl install xdebug-${XDEBUG_VERSION}

RUN set -ex \
    && echo "zend_extension=xdebug.so" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_handler=dbgp" >> /usr/local/etc/php/conf.d/xdebug.ini  \
    && echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/xdebug.ini  \
    && echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/xdebug.ini  \
    && echo "xdebug.idekey=PHPSTORM" >> /usr/local/etc/php/conf.d/xdebug.ini  \
    && echo "xdebug.client_port=9090" >> /usr/local/etc/php/conf.d/xdebug.ini  \
    && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/xdebug.ini ;

# Set working directory
WORKDIR /app

USER $user
