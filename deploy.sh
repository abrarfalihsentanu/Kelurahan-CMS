#!/bin/bash
###############################################
# Deploy Script - Kelurahan Petamburan CMS
# Jalankan di server production setelah git pull
#
# Usage: bash deploy.sh
###############################################

set -e

echo "=========================================="
echo "  Deploy Kelurahan Petamburan CMS"
echo "=========================================="

# 1. Maintenance mode ON
echo ""
echo "[1/9] Mengaktifkan maintenance mode..."
php artisan down --retry=60

# 2. Install composer dependencies (production)
echo ""
echo "[2/9] Install composer dependencies (production)..."
composer install --no-dev --optimize-autoloader --no-interaction

# 3. Run migrations
echo ""
echo "[3/9] Menjalankan database migrations..."
php artisan migrate --force

# 4. Clear old caches
echo ""
echo "[4/9] Membersihkan cache lama..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# 5. Rebuild caches for production
echo ""
echo "[5/9] Membuat cache optimasi production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# 6. Storage link
echo ""
echo "[6/9] Memastikan storage symlink..."
php artisan storage:link 2>/dev/null || echo "  -> Storage link sudah ada"

# 7. Set permissions
echo ""
echo "[7/9] Mengatur permissions..."
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || echo "  -> Sesuaikan owner dengan user web server Anda"

# 8. Generate APP_KEY jika belum ada
echo ""
echo "[8/9] Mengecek APP_KEY..."
if grep -q "APP_KEY=$" .env || grep -q "APP_KEY=<GANTI" .env; then
    echo "  -> Generating APP_KEY baru..."
    php artisan key:generate --force
else
    echo "  -> APP_KEY sudah ada"
fi

# 9. Maintenance mode OFF
echo ""
echo "[9/9] Menonaktifkan maintenance mode..."
php artisan up

echo ""
echo "=========================================="
echo "  Deploy selesai!"
echo "=========================================="
echo ""
echo "Checklist post-deploy:"
echo "  - Pastikan APP_ENV=production di .env"
echo "  - Pastikan APP_DEBUG=false di .env"
echo "  - Pastikan DB credentials sudah benar"
echo "  - Pastikan SESSION_SECURE_COOKIE=true jika HTTPS"
echo "  - Test akses frontend dan admin panel"
echo ""
