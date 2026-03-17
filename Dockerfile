FROM php:8.3-fpm

WORKDIR /var/www/html

# Dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    npm \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Ajusta permissões para rodar suave
RUN usermod -u 1000 www-data

# Copia código (quando buildar)
COPY . .

# Instala dependências se vendor não existir
RUN if [ ! -d "vendor" ]; then composer install; fi

# Permissões Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

USER www-data

EXPOSE 9000

ENV HOME=/var/www/html
ENV NPM_CONFIG_CACHE=/var/www/html/.npm