#!/bin/sh
set -e

cd /var/www/html

# Pastikan direktori Laravel tersedia
mkdir -p \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache

# Atur permission
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Jalankan migrasi database yang belum diterapkan
php artisan migrate --force

# Optimasi konfigurasi Laravel
php artisan config:cache
php artisan view:cache

# Jalankan Nginx dan PHP-FPM melalui Supervisor
exec /usr/bin/supervisord -c /etc/supervisord.conf
