# 🌐 Web Server Configuration Files

## Nginx Configuration (Recommended)

### File: `/etc/nginx/sites-available/kelurahan-cms`

```nginx
# HTTP to HTTPS redirect
server {
    listen 80;
    listen [::]:80;
    server_name yourdomain.com www.yourdomain.com;
    return 301 https://$server_name$request_uri;
}

# HTTPS Configuration
server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;

    server_name yourdomain.com www.yourdomain.com;
    root /var/www/kelurahan-cms/public;
    index index.php;

    # SSL Certificates
    ssl_certificate /etc/letsencrypt/live/yourdomain.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/yourdomain.com/privkey.pem;

    # SSL Configuration
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers ECDHE-ECDSA-AES128-GCM-SHA256:ECDHE-RSA-AES128-GCM-SHA256:ECDHE-ECDSA-AES256-GCM-SHA384:ECDHE-RSA-AES256-GCM-SHA384:DHE-RSA-AES128-GCM-SHA256:DHE-RSA-AES256-GCM-SHA384;
    ssl_prefer_server_ciphers on;
    ssl_session_cache shared:SSL:10m;
    ssl_session_timeout 10m;
    ssl_stapling on;
    ssl_stapling_verify on;

    # Security Headers
    add_header Strict-Transport-Security "max-age=31536000; includeSubDomains; preload" always;
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header Referrer-Policy "no-referrer-when-downgrade" always;
    add_header Content-Security-Policy "default-src 'self' https: data: blob: 'unsafe-inline' 'unsafe-eval';" always;
    add_header Permissions-Policy "geolocation=(), microphone=(), camera=()" always;

    # Gzip Compression
    gzip on;
    gzip_vary on;
    gzip_proxied any;
    gzip_comp_level 6;
    gzip_types text/plain text/css text/xml text/javascript application/json application/javascript application/xml+rss application/rss+xml;
    gzip_disable "msie6";

    # Logging
    access_log /var/log/nginx/kelurahan-cms_access.log combined buffer=32k flush=5s;
    error_log /var/log/nginx/kelurahan-cms_error.log warn;

    # File upload limit (20MB)
    client_max_body_size 20M;

    # Disable server token
    server_tokens off;

    # Disable directory listing
    autoindex off;

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

    # Block access to Laravel storage logs
    location ~ ^/storage/logs/ {
        deny all;
        access_log off;
        log_not_found off;
    }

    # Block access to Laravel bootstrap/cache
    location ~ ^/bootstrap/cache/ {
        deny all;
        access_log off;
        log_not_found off;
    }

    # Cache static assets (1 year)
    location ~* \.(js|css|png|jpg|jpeg|gif|ico|svg|woff|woff2|ttf|eot)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }

    # Cache HTML (1 week)
    location ~* \.html$ {
        expires 1w;
        add_header Cache-Control "public";
    }

    # PHP-FPM Configuration
    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_connect_timeout 60;
        fastcgi_send_timeout 60;
        fastcgi_read_timeout 60;
        fastcgi_buffer_size 128k;
        fastcgi_buffers 256 16k;
        fastcgi_busy_buffers_size 256k;
    }

    # Main application routing
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # Deny access to shell scripts and configuration files
    location ~ \.(sh|conf|yml|yaml|env)$ {
        deny all;
    }

    # Restrict access to specific files
    location ~ (composer.json|package.json|artisan|storage|bootstrap) {
        deny all;
    }
}
```

### Enable Nginx site:

```bash
sudo ln -s /etc/nginx/sites-available/kelurahan-cms /etc/nginx/sites-enabled/
sudo nginx -t  # Test configuration
sudo systemctl restart nginx
```

---

## Apache Configuration

### File: `/etc/apache2/sites-available/kelurahan-cms.conf`

```apache
# HTTP to HTTPS redirect
<VirtualHost *:80>
    ServerName yourdomain.com
    ServerAlias www.yourdomain.com
    Redirect permanent / https://yourdomain.com/
</VirtualHost>

# HTTPS Configuration
<VirtualHost *:443>
    ServerName yourdomain.com
    ServerAlias www.yourdomain.com

    DocumentRoot /var/www/kelurahan-cms/public
    ServerAdmin admin@yourdomain.com

    # SSL Configuration
    SSLEngine on
    SSLCertificateFile /etc/letsencrypt/live/yourdomain.com/fullchain.pem
    SSLCertificateKeyFile /etc/letsencrypt/live/yourdomain.com/privkey.pem

    # SSL Protocol Settings
    SSLProtocol -all +TLSv1.2 +TLSv1.3
    SSLCipherSuite ECDHE-ECDSA-AES128-GCM-SHA256:ECDHE-RSA-AES128-GCM-SHA256:ECDHE-ECDSA-AES256-GCM-SHA384
    SSLHonorCipherOrder on
    SSLCompression off

    # HSTS Header
    Header always set Strict-Transport-Security "max-age=31536000; includeSubDomains; preload"

    # Security Headers
    Header always set X-Frame-Options "SAMEORIGIN"
    Header always set X-Content-Type-Options "nosniff"
    Header always set X-XSS-Protection "1; mode=block"
    Header always set Referrer-Policy "no-referrer-when-downgrade"
    Header always set Content-Security-Policy "default-src 'self' https: data: blob: 'unsafe-inline' 'unsafe-eval';"

    # Logging
    ErrorLog ${APACHE_LOG_DIR}/kelurahan-cms_error.log
    CustomLog ${APACHE_LOG_DIR}/kelurahan-cms_access.log combined

    # Gzip Compression
    <IfModule mod_deflate.c>
        AddOutputFilterByType DEFLATE text/plain text/html text/xml text/css text/javascript
        AddOutputFilterByType DEFLATE application/xml application/xhtml+xml application/rss+xml
        AddOutputFilterByType DEFLATE application/javascript application/x-javascript
        AddEncoding gzip .gz
        DeflateCompressionLevel 6
    </IfModule>

    # File upload limit (20MB)
    <IfModule mod_php.c>
        php_value upload_max_filesize 20M
        php_value post_max_size 20M
    </IfModule>

    <Directory /var/www/kelurahan-cms/public>
        <IfModule mod_rewrite.c>
            Options -MultiViews
            RewriteEngine On

            # Redirect trailing slashes
            RewriteCond %{REQUEST_FILENAME} !-d
            RewriteRule ^(.*)/$ /$1 [L,R=301]

            # Send requests to index.php
            RewriteCond %{REQUEST_FILENAME} !-d
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteRule ^ index.php [QSA,L]
        </IfModule>

        # Directory settings
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    # Block access to sensitive files and directories
    <FilesMatch "\.env|\.env\..*|\.git|artisan|storage|bootstrap|\.php$">
        <If "!(%{REQUEST_URI} =~ m#^/index\.php#)">
            Deny from all
        </If>
    </FilesMatch>

    # Block access to hidden files
    <FilesMatch "^\.|~$">
        Deny from all
    </FilesMatch>

    # Block access to storage directory
    <Directory /var/www/kelurahan-cms/storage>
        Deny from all
    </Directory>

    # Block access to bootstrap/cache
    <Directory /var/www/kelurahan-cms/bootstrap/cache>
        Deny from all
    </Directory>

    # Cache static assets (1 year)
    <IfModule mod_expires.c>
        ExpiresActive On
        ExpiresDefault "access plus 2 days"
        ExpiresByType image/jpg "access plus 1 year"
        ExpiresByType image/jpeg "access plus 1 year"
        ExpiresByType image/gif "access plus 1 year"
        ExpiresByType image/png "access plus 1 year"
        ExpiresByType image/svg+xml "access plus 1 year"
        ExpiresByType application/javascript "access plus 1 year"
        ExpiresByType text/css "access plus 1 year"
        ExpiresByType text/html "access plus 1 week"
    </IfModule>

    # ETags Configuration
    <IfModule mod_headers.c>
        Header unset ETag
        FileETag None
    </IfModule>

    # Disable directory listing
    <IfModule mod_autoindex.c>
        Options -Indexes
    </IfModule>

    # ModSecurity (optional WAF)
    <IfModule mod_security.c>
        SecRuleEngine On
        SecRequestBodyAccess On
    </IfModule>
</VirtualHost>
```

### Enable Apache site:

```bash
# Enable required modules
sudo a2enmod rewrite headers deflate ssl expires

# Enable site
sudo a2ensite kelurahan-cms.conf

# Remove default site
sudo a2dissite 000-default.conf

# Test configuration
sudo apache2ctl configtest

# Restart Apache
sudo systemctl restart apache2
```

---

## .htaccess File

### File: `/var/www/kelurahan-cms/public/.htaccess`

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews
    </IfModule>

    RewriteEngine On

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>

# Security Headers
<IfModule mod_headers.c>
    Header always set X-Content-Type-Options "nosniff"
    Header always set X-Frame-Options "SAMEORIGIN"
    Header always set X-XSS-Protection "1; mode=block"
    Header always set Referrer-Policy "no-referrer-when-downgrade"
</IfModule>

# Disable directory listing
Options -Indexes

# Disable access to hidden files
<FilesMatch "^\.|\.env|\.git">
    Deny from all
</FilesMatch>

# Prevent script execution in storage
<DirectoryMatch "storage|bootstrap/cache">
    <FilesMatch "\.php$">
        Deny from all
    </FilesMatch>
</DirectoryMatch>

# Gzip compression
<IfModule mod_deflate.c>
    AddType application/x-gzip .gz
    AddEncoding gzip .gz
</IfModule>
```

---

## PHP Configuration

### File: `/etc/php/8.1/fpm/php.ini`

```ini
; Performance & Security Settings

; File Upload
upload_max_filesize = 20M
post_max_size = 20M
file_uploads = On

; Execution
max_execution_time = 300
max_input_time = 300
memory_limit = 256M

; Security - Disable dangerous functions
disable_functions = exec,passthru,shell_exec,system,proc_open,popen,curl_exec,curl_multi_exec,parse_ini_file,show_source,symlink,link,hardlink,readlink,fsockopen,pfsockopen,openlog,syslog,highlight_file,ini_alter,proc_terminate,proc_nice,proc_get_status,proc_close,popen,pcntl_exec

; Session Security
session.cookie_secure = 1
session.cookie_httponly = 1
session.cookie_samesite = "Lax"
session.use_only_cookies = 1
session.cookie_lifetime = 0

; Display Errors (disable in production)
display_errors = Off
display_startup_errors = Off
log_errors = On
error_log = /var/log/php/error.log

; Type Checking
strict_types = 1
```

### PHP-FPM Pool Configuration

#### File: `/etc/php/8.1/fpm/pool.d/www.conf`

```ini
[www]
user = www-data
group = www-data

; Address to accept FastCGI requests on
listen = /var/run/php/php8.1-fpm.sock
listen.owner = www-data
listen.group = www-data
listen.mode = 0666

; Process Manager
pm = dynamic
pm.max_children = 20
pm.start_servers = 5
pm.min_spare_servers = 3
pm.max_spare_servers = 10
pm.max_requests = 1000

; Timeouts
request_terminate_timeout = 300

; Additional environment
env[PATH] = /usr/local/bin:/usr/bin:/bin
env[TMP] = /tmp
env[TMPDIR] = /tmp
env[TEMP] = /tmp
```

---

## MySQL Configuration

### File: `/etc/mysql/mysql.conf.d/mysqld.cnf`

```ini
# Performance Optimization

# Connection Settings
max_connections = 200
max_allowed_packet = 256M

# InnoDB Settings (default for Laravel)
default_storage_engine = InnoDB
innodb_buffer_pool_size = 1G
innodb_log_file_size = 100M
innodb_flush_log_at_trx_commit = 2

# Slow Query Log (useful for optimization)
slow_query_log = 1
slow_query_log_file = /var/log/mysql/slow.log
long_query_time = 2

# Query Cache
query_cache_type = 1
query_cache_size = 100M
query_cache_limit = 2M

# Character Set
character_set_server = utf8mb4
collation_server = utf8mb4_unicode_ci

# Security
skip-symbolic-links = 1
```

---

## Supervisor Configuration (For Queue Workers)

### File: `/etc/supervisor/conf.d/kelurahan-cms-worker.conf`

```ini
[program:kelurahan-cms-queue-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/kelurahan-cms/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
user=www-data
numprocs=1
redirect_stderr=true
stdout_logfile=/var/log/kelurahan-cms-worker.log
```

### Enable Supervisor:

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start kelurahan-cms-queue-worker:*
```

---

## Redis Configuration

### File: `/etc/redis/redis.conf`

```
# Server
port 6379
bind 127.0.0.1
databases 16

# Memory
maxmemory 512mb
maxmemory-policy allkeys-lru

# Persistence
save 900 1
save 300 10
save 60 10000

# Security
requirepass your_strong_redis_password_here

# Logging
loglevel notice
logfile /var/log/redis/redis-server.log
```

---

## Systemd Service File

### File: `/etc/systemd/system/kelurahan-cms.service`

```ini
[Unit]
Description=Kelurahan CMS Application
After=network.target

[Service]
Type=notify
User=www-data
Group=www-data
WorkingDirectory=/var/www/kelurahan-cms

ExecStart=/usr/bin/php-cgi -b 127.0.0.1:9000
Restart=always
RestartSec=10

[Install]
WantedBy=multi-user.target
```

Enable: `sudo systemctl enable kelurahan-cms && sudo systemctl start kelurahan-cms`

---

**Configuration files are ready for production deployment!** 🚀
