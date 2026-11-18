#!/bin/sh
set -e

cd /var/www/html

# Gunakan port yang diberikan Hostless
PORT="${PORT:-8080}"

# Sesuaikan port Nginx
sed "s/listen 10000;/listen ${PORT};/" \
    /etc/nginx/http.d/default.conf > /tmp/default.conf

cp /tmp/default.conf /etc/nginx/http.d/default.conf

# Siapkan direktori Laravel
mkdir -p \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache

chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Jalankan migration
php artisan migrate --force

# Optimasi Laravel
php artisan config:cache
php artisan view:cache

# Jalankan server
exec /usr/bin/supervisord -c /etc/supervisord.conf
