# syntax=docker/dockerfile:1.7

# ---------- Stage 1: composer deps ----------
FROM composer:2.8 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN --mount=type=cache,target=/root/.composer/cache \
    composer install --no-dev --no-interaction --no-scripts --prefer-dist --optimize-autoloader

# ---------- Stage 2: frontend assets ----------
FROM node:22-alpine AS assets
WORKDIR /app
COPY package.json package-lock.json ./
RUN --mount=type=cache,target=/root/.npm \
    npm ci --ignore-scripts --no-audit --no-fund
COPY vite.config.js tailwind.config.js postcss.config.js ./
COPY resources ./resources
COPY public ./public
RUN npm run build

# ---------- Stage 3: runtime ----------
FROM php:8.4-fpm-alpine AS runtime

RUN apk add --no-cache \
        bash \
        curl \
        git \
        icu-dev \
        libzip-dev \
        mysql-client \
        nginx \
        oniguruma-dev \
        shadow \
        supervisor \
        tzdata \
    && docker-php-ext-install bcmath intl opcache pdo_mysql zip \
    && apk add --no-cache --virtual .build-deps autoconf g++ make \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del .build-deps \
    && cp /usr/share/zoneinfo/Asia/Jakarta /etc/localtime \
    && echo "Asia/Jakarta" > /etc/timezone

WORKDIR /var/www

COPY --from=vendor /app/vendor ./vendor
COPY --from=assets /app/public/build ./public/build

COPY . .

RUN cp .env.example .env \
    && mkdir -p storage/framework/{cache/data,sessions,testing,views} storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R ug+rwX storage bootstrap/cache

# Entrypoint
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Supervisor (php-fpm + queue worker + scheduler + nginx)
COPY docker/supervisord.conf /etc/supervisord.conf
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/php.ini /usr/local/etc/php/conf.d/zz-app.ini

EXPOSE 80
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["supervisord", "-c", "/etc/supervisord.conf"]