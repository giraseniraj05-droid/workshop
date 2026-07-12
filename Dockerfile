# ---- Stage 1: build frontend assets ----
FROM node:20-alpine AS frontend
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY resources ./resources
COPY vite.config.js tailwind.config.js postcss.config.js ./
RUN npm run build

# ---- Stage 2: PHP app ----
FROM php:8.3-apache

# System deps + PHP extensions (including mongodb via PECL)
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libonig-dev libxml2-dev libssl-dev pkg-config \
    && docker-php-ext-install pdo_mysql zip mbstring exif pcntl bcmath \
    && pecl channel-update pecl.php.net \
    && pecl install mongodb && docker-php-ext-enable mongodb \
    && a2enmod rewrite \
    && apt-get purge -y --auto-remove -o APT::AutoRemove::RecommendsImportant=false git unzip \
    && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .
COPY --from=frontend /app/public/build ./public/build

RUN composer install --no-dev --optimize-autoloader --no-interaction \
    && cp .env.example .env \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Point Apache at Laravel's public/ folder
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

EXPOSE 80

CMD ["sh", "-c", "php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan storage:link && php artisan mongodb:create-indexes && apache2-foreground"]