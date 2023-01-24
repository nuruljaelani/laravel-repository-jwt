FROM php:fpm

ARG user
ARG uid

RUN apt-get update && apt-get install -y \
  git \
  curl \
  nodejs \
  libpng-dev \
  libpq-dev \
  libonig-dev \
  libxml2-dev \
  zip \
  unzip

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Set working directory
WORKDIR /var/www

USER $user