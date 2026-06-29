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
rm -f /var/www/public/storage
php artisan storage:link --force 2>&1 || {
    echo "[entrypoint] WARNING: storage:link failed, creating symlink manually..."
    ln -sf ../storage/app/public /var/www/public/storage
}

echo "[entrypoint] Fixing storage permissions..."
chown -R www-data:www-data /var/www/storage/app/public 2>/dev/null || true
chmod -R 775 /var/www/storage/app/public 2>/dev/null || true

echo "[entrypoint] Fixing nginx tmp permissions..."
mkdir -p /var/lib/nginx/tmp /var/log/nginx
chown -R www-data:www-data /var/lib/nginx /var/log/nginx 2>/dev/null || true
chmod -R 755 /var/lib/nginx /var/log/nginx 2>/dev/null || true

echo "[entrypoint] Optimizing..."
php artisan optimize || true

echo "[entrypoint] Handing off to: $*"
exec "$@"