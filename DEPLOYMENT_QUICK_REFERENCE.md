# 🚀 Quick Deployment Reference

## One-Line Setup (For experienced DevOps)

```bash
git clone https://github.com/abrarfalihsentanu/Kelurahan-CMS.git && cd Kelurahan-CMS && \
composer install --optimize-autoloader --no-dev && npm install && npm run build && \
cp .env.example .env && php artisan key:generate && \
php artisan migrate:fresh --seed --force && \
php artisan cache:all
```

---

## Hosting Provider Specific Guides

### 🔶 Cpanel/Shared Hosting

1. **Upload via File Manager or Git**
    - Upload project files to `public_html` or subdomain folder
    - Or use Git: `git clone repo url`

2. **Create .env**

    ```bash
    cp .env.example .env
    # Edit via File Manager
    ```

3. **Create Database**
    - Use cPanel Database Management
    - Create MySQL user with appropriate privileges

4. **Database Credentials**
    - Update .env with database name, user, password

5. **Run Migrations**
    - Via Terminal/SSH: `php artisan migrate --force`
    - Or setup a cron job for automated migrations

6. **File Permissions**
    - storage folder: chmod 755
    - bootstrap/cache: chmod 755

7. **Public Folder Setup**
    - Point domain to `public` folder in cPanel

---

### 🟦 Digital Ocean / Linode / AWS

1. **Server Setup**

    ```bash
    # Connect via SSH
    ssh root@your_server_ip

    # Update system
    sudo apt update && sudo apt upgrade -y
    ```

2. **Install Dependencies**

    ```bash
    # Update Ubuntu first
    sudo apt-get update
    sudo apt-get upgrade -y

    # Install web server
    sudo apt-get install -y nginx

    # Install PHP
    sudo apt-get install -y php8.1-fpm php8.1-mysql php8.1-mbstring \
    php8.1-curl php8.1-json php8.1-xml php8.1-zip

    # Install MySQL
    sudo apt-get install -y mysql-server

    # Install Node.js
    sudo apt-get install -y nodejs npm

    # Install Git
    sudo apt-get install -y git

    # Install Redis (recommended)
    sudo apt-get install -y redis-server
    ```

3. **Setup Project**

    ```bash
    sudo mkdir -p /var/www
    cd /var/www
    sudo git clone https://github.com/abrarfalihsentanu/Kelurahan-CMS.git
    cd Kelurahan-CMS
    ```

4. **Fix Permissions**

    ```bash
    sudo chown -R www-data:www-data /var/www/Kelurahan-CMS
    sudo chmod -R 775 /var/www/Kelurahan-CMS/storage
    sudo chmod -R 775 /var/www/Kelurahan-CMS/bootstrap/cache
    ```

5. **Install PHP Dependencies**

    ```bash
    curl -sS https://getcomposer.org/installer | php
    sudo mv composer.phar /usr/local/bin/composer
    composer install --optimize-autoloader --no-dev
    ```

6. **Setup Database**

    ```bash
    # Create database
    mysql -u root -p
    CREATE DATABASE kelurahan_cms_prod;
    CREATE USER 'kelurahan_user'@'localhost' IDENTIFIED BY 'strong_password';
    GRANT ALL PRIVILEGES ON kelurahan_cms_prod.* TO 'kelurahan_user'@'localhost';
    FLUSH PRIVILEGES;
    ```

7. **Configure .env**

    ```bash
    cp .env.example .env
    php artisan key:generate
    # Edit .env with database credentials
    nano .env
    ```

8. **Run Migrations**

    ```bash
    php artisan migrate --force
    php artisan db:seed --force
    ```

9. **Compile Assets**

    ```bash
    npm install
    npm run build
    ```

10. **Create Storage Link**

    ```bash
    php artisan storage:link
    ```

11. **Configure Web Server (Nginx)**

    ```bash
    sudo nano /etc/nginx/sites-available/kelurahan-cms
    # Paste Nginx config (see nginx-config.txt)

    sudo ln -s /etc/nginx/sites-available/kelurahan-cms /etc/nginx/sites-enabled/
    sudo nginx -t
    sudo systemctl restart nginx
    ```

12. **Setup SSL**

    ```bash
    sudo apt-get install certbot python3-certbot-nginx
    sudo certbot certonly --nginx -d yourdomain.com -d www.yourdomain.com
    ```

13. **Cache Configuration**
    ```bash
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    ```

---

### 🟦 Heroku Deployment

1. **Install Heroku CLI**

    ```bash
    curl https://cli-assets.heroku.com/install.sh | sh
    ```

2. **Initialize Heroku App**

    ```bash
    heroku login
    heroku create your-app-name
    ```

3. **Add Procfile**

    ```bash
    echo "web: vendor/bin/heroku-php-apache2 public/" > Procfile
    ```

4. **Set Environment Variables**

    ```bash
    heroku config:set APP_ENV=production
    heroku config:set APP_DEBUG=false
    heroku config:set APP_KEY=base64:your_key_here
    ```

5. **Add MySQL Add-on**

    ```bash
    heroku addons:create cleardb:ignite
    ```

6. **Deploy**

    ```bash
    git push heroku main
    ```

7. **Run Migrations**
    ```bash
    heroku run php artisan migrate --force
    heroku run php artisan db:seed --force
    ```

---

### 🟦 Railway / Render / Fly.io

All cloud platforms have similar deployment processes:

1. Connect Git repository
2. Set environment variables
3. Add database (PostgreSQL or MySQL)
4. Deploy (auto-triggered on git push)

---

## Docker Deployment

Create `Dockerfile`:

```dockerfile
FROM php:8.1-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    git curl wget \
    libpng-dev libjpeg-dev libfreetype6-dev \
    libzip-dev zip unzip \
    mysql-client

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install -j$(nproc) gd mbstring pdoin_mysql zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy project
COPY . .

# Install dependencies
RUN composer install --optimize-autoloader --no-dev

# Build assets
RUN npm install && npm run build

# Generate key
RUN php artisan key:generate

# Run migrations
RUN php artisan migrate --force

EXPOSE 9000
```

Create `docker-compose.yml`:

```yaml
version: "3.8"

services:
    app:
        build: .
        ports:
            - "9000:9000"
        environment:
            - DB_HOST=mysql
            - DB_DATABASE=kelurahan_cms
            - DB_USERNAME=root
            - DB_PASSWORD=root
        depends_on:
            - mysql
            - redis

    mysql:
        image: mysql:8.0
        environment:
            - MYSQL_ROOT_PASSWORD=root
            - MYSQL_DATABASE=kelurahan_cms
        volumes:
            - mysql_data:/var/lib/mysql
        ports:
            - "3306:3306"

    redis:
        image: redis:7
        ports:
            - "6379:6379"

    nginx:
        image: nginx:alpine
        ports:
            - "80:80"
            - "443:443"
        volumes:
            - ./nginx.conf:/etc/nginx/nginx.conf:ro
            - ./public:/app/public:ro
        depends_on:
            - app

volumes:
    mysql_data:
```

Run with: `docker-compose up -d`

---

## Automated Backup Script

Save as `/var/www/kelurahan-cms/backup.sh`:

```bash
#!/bin/bash

BACKUP_DIR="/home/backups/kelurahan-cms"
TIMESTAMP=$(date +%Y%m%d_%H%M%S)
DB_USER="kelurahan_user"
DB_PASS="your_password"
DB_NAME="kelurahan_cms_prod"

mkdir -p $BACKUP_DIR

# Database backup
mysqldump -u $DB_USER -p$DB_PASS $DB_NAME | gzip > $BACKUP_DIR/db_$TIMESTAMP.sql.gz

# Files backup
tar -czf $BACKUP_DIR/files_$TIMESTAMP.tar.gz \
  /var/www/kelurahan-cms/storage \
  /var/www/kelurahan-cms/.env

# Remove old backups (keep 30 days)
find $BACKUP_DIR -mtime +30 -delete

# Upload to cloud (optional - uncomment if using AWS S3)
# aws s3 cp $BACKUP_DIR s3://your-bucket/kelurahan-cms-backup/$TIMESTAMP/ --recursive

echo "Backup completed: $TIMESTAMP"
```

Add to crontab: `0 2 * * * bash /var/www/kelurahan-cms/backup.sh`

---

## Performance Optimization After Deployment

```bash
# 1. Optimize Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 2. Optimize Composer
composer dump-autoload --optimize

# 3. Enable MySQL query cache (my.cnf)
query_cache_type = 1
query_cache_size = 100M

# 4. Setup PHP-FPM max_children (for VPS)
# Edit: /etc/php/8.1/fpm/pool.d/www.conf
pm = dynamic
pm.max_children = 20
pm.start_servers = 3
pm.min_spare_servers = 2
pm.max_spare_servers = 5

# 5. Redis configuration
redis-server --daemonize yes

# 6. MySQL optimization
OPTIMIZE TABLE users;
OPTIMIZE TABLE news;
ANALYZE TABLE users;
```

---

## Security Hardening Quick Checklist

- [ ] APP_DEBUG = false
- [ ] APP_ENV = production
- [ ] HTTPS enabled
- [ ] Strong database password
- [ ] SSH key authentication only
- [ ] Firewall enabled
- [ ] Fail2Ban installed
- [ ] Regular backups
- [ ] Security headers added
- [ ] Admin password changed
- [ ] .env permissions: 600
- [ ] Storage folder not accessible from web

---

## Admin Access

After deployment, login with:

- **Email:** admin@kelurahan-petamburan.go.id
- **Password:** password (CHANGE IMMEDIATELY!)

To change admin password:

```bash
php artisan tinker
$user = User::where('email', 'admin@kelurahan-petamburan.go.id')->first();
$user->password = Hash::make('new_secure_password');
$user->save();
```

---

## Monitoring Command

Monitor your deployment in real-time:

```bash
# Watch logs in real-time
tail -f /var/www/kelurahan-cms/storage/logs/laravel.log

# Check PHP-FPM status
ps aux | grep php-fpm

# Check Nginx status
sudo systemctl status nginx

# Check MySQL status
sudo systemctl status mysql

# Check server resources
watch -n 2 'free -h && echo "---" && df -h'
```

---

**Ready for production?**

1. ✅ All security fixes applied
2. ✅ Migrations run successfully
3. ✅ Database seeded with admin user
4. ✅ Audit passed
5. ✅ Assets compiled
6. ✅ SSL configured
7. ✅ Backups scheduled

**Deploy with confidence!** 🚀
