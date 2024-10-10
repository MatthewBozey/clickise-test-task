FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    nano \
    libpq-dev \
    libzip-dev \
    nodejs \
    npm \
    supervisor \
    && docker-php-ext-install pdo pdo_pgsql pgsql zip gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN curl -fsSL https://deb.nodesource.com/setup_16.x | bash - \
    && apt-get install -y nodejs

WORKDIR /var/www
COPY . /var/www
RUN composer install --no-interaction --optimize-autoloader

RUN npm install

RUN npm run build

COPY ./supervisord.conf /etc/supervisor/conf.d/supervisord.conf

RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www

EXPOSE 9000 5173

CMD ["php-fpm"]
