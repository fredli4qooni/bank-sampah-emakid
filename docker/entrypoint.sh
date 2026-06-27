#!/bin/sh
set -e

echo "[entrypoint] Generating APP_KEY if missing..."
if [ -z "$APP_KEY" ]; then
    APP_KEY=$(grep -E '^APP_KEY=' .env | cut -d'=' -f2)
    if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "" ]; then
        php artisan key:generate --force --no-interaction
    fi
fi

echo "[entrypoint] Caching config..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "[entrypoint] Running migrations..."
php artisan migrate --force --no-interaction

echo "[entrypoint] Storage link..."
php artisan storage:link || true

echo "[entrypoint] Optimizing..."
php artisan optimize || true

echo "[entrypoint] Handing off to: $*"
exec "$@"