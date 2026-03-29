# 🚀 Production Deployment & Hosting Setup Guide

**Kelurahan Petamburan CMS - Production Ready Configuration**

---

## 📋 Table of Contents

1. [Pre-Deployment Checklist](#pre-deployment-checklist)
2. [Server Requirements](#server-requirements)
3. [Deployment Steps](#deployment-steps)
4. [Environment Configuration](#environment-configuration)
5. [Security Hardening](#security-hardening)
6. [Performance Optimization](#performance-optimization)
7. [Monitoring & Maintenance](#monitoring--maintenance)
8. [Troubleshooting](#troubleshooting)

---

## ✅ Pre-Deployment Checklist

- [ ] **Code Quality**
    - [ ] All tests passing: `php artisan test`
    - [ ] No debug mode: `APP_DEBUG=false`
    - [ ] All sensitive data removed from code
    - [ ] Database credentials not in repository

- [ ] **Database**
    - [ ] Backup created
    - [ ] Migrations tested on staging
    - [ ] Seeding verified (if needed)

- [ ] **Security**
    - [ ] SSL/TLS certificate installed
    - [ ] .env file secured (not in version control)
    - [ ] File permissions set correctly
    - [ ] Admin users created with strong passwords

- [ ] **Performance**
    - [ ] Cache cleared: `php artisan config:cache`
    - [ ] Routes cached: `php artisan route:cache`
    - [ ] Assets compiled with Vite

- [ ] **Backups**
    - [ ] Database backup
    - [ ] File storage backup
    - [ ] .env backup (stored securely)

---

## 🖥️ Server Requirements

### Minimum Specifications

```
- PHP: 8.1 or higher
- MySQL: 8.0 or higher
- RAM: 2GB minimum
- Storage: 10GB minimum
- Disk Speed: SSD recommended
```

### PHP Extensions Required

```
- bcmath
- ctype
- curl
- dom
- fileinfo
- filter
- hash
- json
- mbstring
- openssl
- pcre
- pdo
- pdo_mysql
- tokenizer
- xml
```

### Recommended Server Software

```
- Nginx (recommended) or Apache
- Systemd for process management
- Supervisor for queue workers (if using queues)
- Redis (for caching & sessions)
- Composer 2.x
```

### Hosting Providers (Tested)

- ✅ Digital Ocean
- ✅ Linode
- ✅ AWS (EC2)
- ✅ Google Cloud
- ✅ Vultr
- ✅ Shared Hosting with SSH access

---

## 📦 Deployment Steps

### Step 1: Clone Repository to Server

```bash
cd /var/www
sudo git clone https://github.com/abrarfalihsentanu/Kelurahan-CMS.git kelurahan-cms
cd kelurahan-cms
```

### Step 2: Set Permissions

```bash
sudo chown -R www-data:www-data /var/www/kelurahan-cms
sudo chmod -R 775 /var/www/kelurahan-cms
sudo chmod -R 775 storage bootstrap/cache
```

### Step 3: Install Dependencies

```bash
composer install --optimize-autoloader --no-dev
npm install
npm run build  # For production build
```

### Step 4: Configure Environment

```bash
cp .env.example .env
# Edit .env with production settings
nano .env
```

### Step 5: Generate Application Key

```bash
php artisan key:generate
```

### Step 6: Create Directories & Set Permissions

```bash
mkdir -p storage/app/public/pages
mkdir -p storage/app/public/news
mkdir -p storage/app/public/infographics
mkdir -p storage/app/public/galleries
mkdir -p storage/logs

sudo chmod -R 755 storage/logs
```

### Step 7: Create Storage Link

```bash
php artisan storage:link
```

### Step 8: Run Migrations

```bash
php artisan migrate --force
```

### Step 9: Seed Database (Optional)

```bash
php artisan db:seed --force
```

### Step 10: Cache Configuration

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Step 11: Configure Web Server

See Web Server Configuration sections below.

### Step 12: Set Up SSL Certificate

```bash
# Using Let's Encrypt with Certbot
sudo apt-get install certbot python3-certbot-nginx
sudo certbot certonly --nginx -d yourdomain.com -d www.yourdomain.com
```

---

## 🔧 Environment Configuration

### Production .env Template

```env
# Application
APP_NAME="Kelurahan Petamburan"
APP_ENV=production
APP_KEY=base64:XXXXXXXXXXXXXXXXXXXXXXXXXXXX
APP_DEBUG=false
APP_URL=https://yourdomain.com
TRUSTED_PROXIES=*

# Logging
LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error  # Use 'error' in production

# Database
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=kelurahan_cms_prod
DB_USERNAME=kelurahan_user
DB_PASSWORD=secure_password_123456
DB_COLLATION=utf8mb4_unicode_ci

# Cache & Session
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

# Security
SESSION_SECURE_COOKIE=true
SESSION_HTTP_ONLY=true
SESSION_SAME_SITE=lax

# Redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
REDIS_DB=1

# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=465
MAIL_USERNAME=your_username@mailtrap.io
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="Kelurahan Petamburan"

# AWS S3 (optional, for file storage)
AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=ap-southeast-1
AWS_BUCKET=kelurahan-cms-bucket
AWS_USE_PATH_STYLE_ENDPOINT=false
```

### Critical Environment Variables

| Variable                | Value         | Notes                                     |
| ----------------------- | ------------- | ----------------------------------------- |
| `APP_ENV`               | production    | MUST be production                        |
| `APP_DEBUG`             | false         | NEVER enable on production                |
| `APP_KEY`               | base64:xxx    | Generated with `php artisan key:generate` |
| `DB_*`                  | Production DB | Use secure password (min 16 chars)        |
| `SESSION_SECURE_COOKIE` | true          | Only if using HTTPS                       |
| `CACHE_DRIVER`          | redis         | Redis recommended for performance         |
| `LOG_LEVEL`             | error         | Reduce log verbosity in production        |

---

## 🔒 Security Hardening

### 1. HTTPS/SSL Configuration

```bash
# Nginx - Enable HTTPS
server {
    listen 443 ssl http2;
    server_name yourdomain.com www.yourdomain.com;

    ssl_certificate /etc/letsencrypt/live/yourdomain.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/yourdomain.com/privkey.pem;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers HIGH:!aNULL:!MD5;
    ssl_prefer_server_ciphers on;

    # Redirect HTTP to HTTPS
    return 301 https://$server_name$request_uri;
}
```

### 2. File Permissions

```bash
# Set correct permissions
sudo chmod 644 /var/www/kelurahan-cms/.env
sudo chmod 755 /var/www/kelurahan-cms/
sudo chmod 755 /var/www/kelurahan-cms/storage
sudo chmod 755 /var/www/kelurahan-cms/bootstrap
sudo chmod 755 /var/www/kelurahan-cms/public

# Restrict .env from web access
sudo chmod 600 /var/www/kelurahan-cms/.env
```

### 3. Web Server Security Headers

```nginx
# Nginx - Add Security Headers
add_header X-Frame-Options "SAMEORIGIN" always;
add_header X-XSS-Protection "1; mode=block" always;
add_header X-Content-Type-Options "nosniff" always;
add_header Referrer-Policy "no-referrer-when-downgrade" always;
add_header Content-Security-Policy "default-src 'self' http: https: data: blob: 'unsafe-inline'" always;
add_header Strict-Transport-Security "max-age=31536000; includeSubDomains" always;
```

### 4. Disable Directory Listing

```nginx
# Nginx
autoindex off;
```

### 5. Protect Sensitive Files

```nginx
# Block access to sensitive files
location ~ /\. {
    deny all;
    access_log off;
    log_not_found off;
}

location ~ ~$ {
    deny all;
    access_log off;
    log_not_found off;
}

location ~ ^/storage/logs/ {
    deny all;
    access_log off;
    log_not_found off;
}
```

### 6. Remove Server Banner

```nginx
# Nginx - Hide server version
server_tokens off;
```

### 7. Database User Permissions

```sql
-- Create dedicated database user
CREATE USER 'kelurahan_user'@'localhost' IDENTIFIED BY 'secure_password_123456';

-- Grant only necessary privileges
GRANT SELECT, INSERT, UPDATE, DELETE ON kelurahan_cms_prod.* TO 'kelurahan_user'@'localhost';

-- No SUPER privilege
FLUSH PRIVILEGES;
```

### 8. Admin Account Setup

```bash
# Create admin user (SSH into server)
php artisan tinker

# In tinker:
$user = new App\Models\User();
$user->name = 'Administrator';
$user->email = 'admin@yourdomain.com';
$user->password = Hash::make('very_secure_password_123456');
$user->is_admin = true;
$user->is_active = true;
$user->save();
```

### 9. Regular Backups

```bash
# Database backup script
#!/bin/bash
BACKUP_DIR="/var/backups/kelurahan-cms"
TIMESTAMP=$(date +%Y%m%d_%H%M%S)

mkdir -p $BACKUP_DIR

# Backup database
mysqldump -u kelurahan_user -p'password' kelurahan_cms_prod > $BACKUP_DIR/db_$TIMESTAMP.sql

# Backup files
tar -czf $BACKUP_DIR/files_$TIMESTAMP.tar.gz /var/www/kelurahan-cms/storage

# Keep only last 7 days
find $BACKUP_DIR -name "*.sql" -mtime +7 -delete
find $BACKUP_DIR -name "*.tar.gz" -mtime +7 -delete
```

---

## ⚡ Performance Optimization

### 1. Enable Caching

```bash
# Cache database queries in Redis
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 2. Optimize Database

```sql
-- Create indexes for frequently queried columns
CREATE INDEX idx_news_is_published ON news(is_published);
CREATE INDEX idx_news_published_at ON news(published_at);
CREATE INDEX idx_news_category_id ON news(news_category_id);
CREATE INDEX idx_pages_is_published ON pages(is_published);
CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_users_is_admin ON users(is_admin);
```

### 3. Optimize PHP Configuration

```ini
; /etc/php/8.1/fpm/php.ini
upload_max_filesize = 20M
post_max_size = 20M
max_execution_time = 300
memory_limit = 256M
disable_functions = exec,passthru,shell_exec,system,proc_open,popen,curl_exec
```

### 4. Nginx Configuration for Performance

```nginx
# /etc/nginx/sites-available/kelurahan-cms
server {
    listen 443 ssl http2;
    server_name yourdomain.com www.yourdomain.com;
    root /var/www/kelurahan-cms/public;

    # SSL configuration
    ssl_certificate /etc/letsencrypt/live/yourdomain.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/yourdomain.com/privkey.pem;

    # Gzip compression
    gzip on;
    gzip_types text/plain text/css text/javascript application/json;
    gzip_min_length 1000;

    # Browser caching
    expires 7d;
    add_header Cache-Control "public, immutable";

    # PHP-FPM configuration
    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
    }

    # Public folder access
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # Disable access to hidden files
    location ~ /\. {
        deny all;
    }
}
```

### 5. Enable Query Optimization

```php
// config/database.php
'mysql' => [
    'driver' => 'mysql',
    'host' => env('DB_HOST'),
    'port' => env('DB_PORT'),
    'database' => env('DB_DATABASE'),
    'username' => env('DB_USERNAME'),
    'password' => env('DB_PASSWORD'),
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix' => '',
    'prefix_indexes' => true,
    'strict' => true,
    'engine' => 'InnoDB',
    'options' => [
        PDO::ATTR_EMULATE_PREPARES => true,
    ],
],
```

---

## 📊 Monitoring & Maintenance

### 1. Application Health Checks

```bash
# Create a health check script
cat > /var/www/kelurahan-cms/routes/health.php << 'EOF'
<?php
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now(),
        'database' => DB::connection()->getPdo() ? 'connected' : 'disconnected',
        'cache' => Cache::has('health-check') ? 'working' : 'not-working',
    ]);
});
EOF
```

### 2. Log Monitoring

```bash
# View application logs
tail -f /var/www/kelurahan-cms/storage/logs/laravel.log

# Monitor errors only
tail -f /var/www/kelurahan-cms/storage/logs/laravel.log | grep -i error

# Archive old logs
find /var/www/kelurahan-cms/storage/logs -name "laravel-*.log" -mtime +30 -exec rm {} \;
```

### 3. Database Monitoring

```sql
-- Check database size
SELECT table_schema, ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) AS size_mb
FROM information_schema.tables
GROUP BY table_schema;

-- Check query performance
SHOW VARIABLES LIKE 'slow_query_log%';
SET GLOBAL slow_query_log = 'ON';
SET GLOBAL long_query_time = 2;
```

### 4. Disk Space Monitoring

```bash
# Check disk usage
df -h /var/www/kelurahan-cms

# Check storage directory size
du -sh /var/www/kelurahan-cms/storage/app/public/*

# Setup disk space alerts
du -s /var/www/kelurahan-cms | awk '{if ($1 > 5000000) print "Disk usage alert!"}'
```

### 5. Automated Tasks

```bash
# Add to crontab
crontab -e

# Useful cron jobs
# Clear old cache
0 2 * * * cd /var/www/kelurahan-cms && php artisan cache:clear
# Backup database daily
0 3 * * * /var/www/kelurahan-cms/backup.sh
# Check disk space
0 4 * * * df -h / | mail -s "Disk Space Report" admin@example.com
```

---

## 🐛 Troubleshooting

### Common Issues & Solutions

#### 1. 500 Internal Server Error

```bash
# Check error logs
tail -50 /var/www/kelurahan-cms/storage/logs/laravel.log

# Verify permissions
stat /var/www/kelurahan-cms/storage
stat /var/www/kelurahan-cms/bootstrap/cache

# Check PHP-FPM status
sudo systemctl status php8.1-fpm

# Verify database connection
php artisan tinker
DB::connection()->getPdo()
```

#### 2. Database Connection Error

```bash
# Test database connection
mysql -h localhost -u kelurahan_user -p kelurahan_cms_prod -e "SELECT 1"

# Check MySQL is running
sudo systemctl status mysql

# Verify credentials in .env
cat /var/www/kelurahan-cms/.env | grep DB_
```

#### 3. File Upload Issues

```bash
# Check directory permissions
ls -la /var/www/kelurahan-cms/storage/app/public/

# Set correct permissions
sudo chmod 755 /var/www/kelurahan-cms/storage/app/public
sudo chown -R www-data:www-data /var/www/kelurahan-cms/storage

# Check upload_max_filesize
php -i | grep upload_max_filesize
```

#### 4. Slow Page Load Times

```bash
# Enable query logging
php artisan tinker
DB::enableQueryLog()

# Run page load
# Check queries
dd(DB::getQueryLog())

# Check Redis connection
redis-cli ping

# Monitor PHP-FPM processes
ps aux | grep php-fpm
```

#### 5. SSL/HTTPS Issues

```bash
# Test SSL certificate
openssl s_client -connect yourdomain.com:443

# Check certificate expiration
sudo certbot certificates

# Renew certificate
sudo certbot renew --dry-run
```

---

## 📝 Deployment Checklist

### Pre-Deployment

- [ ] All tests passing
- [ ] Code reviewed
- [ ] .env configured
- [ ] Database backed up
- [ ] Asset compiled

### Deployment

- [ ] Code pulled/deployed
- [ ] Dependencies installed
- [ ] Migrations run
- [ ] Cache cleared
- [ ] SSL configured
- [ ] Domain pointed to server

### Post-Deployment

- [ ] Application loads successfully
- [ ] Login works
- [ ] Admin panel accessible
- [ ] File uploads work
- [ ] HTTPS working
- [ ] Email sending tested
- [ ] Backups configured
- [ ] Monitoring enabled

### First 24 Hours

- [ ] Monitor error logs
- [ ] Check performance metrics
- [ ] Test all features
- [ ] Verify backups running
- [ ] Check security headers

---

## 📞 Support & Resources

### Useful Commands

```bash
# Clear all cache
php artisan cache:clear && php artisan config:cache && php artisan route:cache

# Restart application
sudo systemctl restart php8.1-fpm && sudo systemctl restart nginx

# Update dependencies
composer update --no-dev
npm update

# Deploy new version
git pull origin main
composer install --optimize-autoloader --no-dev
npm run build
php artisan migrate --force
php artisan cache:clear
```

### Quick Reference

| Task           | Command                                      |
| -------------- | -------------------------------------------- |
| Start server   | `php artisan serve`                          |
| Clear cache    | `php artisan cache:clear`                    |
| Run tests      | `php artisan test`                           |
| Database reset | `php artisan migrate:fresh`                  |
| Create user    | `php artisan tinker` then User creation code |
| Check logs     | `tail -f storage/logs/laravel.log`           |

---

**Last Updated:** March 29, 2026  
**Laravel Version:** 10.x  
**PHP Version:** 8.1+

For questions or issues, please refer to:

- Laravel Documentation: https://laravel.com/docs
- MySQL Documentation: https://dev.mysql.com/doc/
- Nginx Documentation: https://nginx.org/en/docs/
