#!/bin/sh
set -e

if [ "${DB_CONNECTION:-sqlite}" = "sqlite" ]; then
    SQLITE_DATABASE="${DB_DATABASE:-}"
    APP_DATABASE_PATH="$(pwd)/database/database.sqlite"

    case "$SQLITE_DATABASE" in
        ""|laravel|C:\\*|C:/*|/Users/*)
            export DB_DATABASE="$APP_DATABASE_PATH"
            ;;
    esac

    mkdir -p "$(dirname "$DB_DATABASE")"
    touch "$DB_DATABASE"
fi

mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views bootstrap/cache
chmod -R ug+rwX storage bootstrap/cache database 2>/dev/null || true

php artisan config:clear >/dev/null 2>&1 || true
php artisan route:clear >/dev/null 2>&1 || true
php artisan view:clear >/dev/null 2>&1 || true

exec "$@"
