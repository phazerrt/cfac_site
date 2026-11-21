#!/bin/sh
set -e

mkdir -p \
    storage/app/public \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache

chown -R www-data:www-data storage bootstrap/cache

# Cache config/routes/views for the web container (php-fpm) only.
if [ "$1" = "php-fpm" ]; then
    su -s /bin/sh www-data -c "php artisan optimize" || echo "artisan optimize failed; continuing uncached"
fi

exec docker-php-entrypoint "$@"
