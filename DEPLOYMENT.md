# Deployment Guide

## Environment Configuration

### Local Development
```bash
# Start development server
php artisan serve --host=0.0.0.0 --port=8000

# Access via
http://localhost:8000
```

### Production Deployment

#### 1. Environment Variables (.env)
```env
APP_NAME="Your CRM App"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Database (use your production database)
DB_CONNECTION=mysql
DB_HOST=your-db-host
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Cache & Session (use Redis/Memcached for production)
CACHE_STORE=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

# Redis
REDIS_HOST=your-redis-host
REDIS_PASSWORD=your-redis-password
REDIS_PORT=6379

# Mail
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email@domain.com
MAIL_PASSWORD=your-email-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@yourdomain.com"
MAIL_FROM_NAME="${APP_NAME}"
```

#### 2. Web Server Configuration

##### Apache (.htaccess in public folder)
```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

##### Nginx
```nginx
server {
    listen 80;
    listen [::]:80;
    server_name yourdomain.com;
    root /var/www/html/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

#### 3. Deployment Commands
```bash
# 1. Install dependencies
composer install --no-dev --optimize-autoloader

# 2. Generate application key
php artisan key:generate

# 3. Run migrations
php artisan migrate --force

# 4. Seed database (if needed)
php artisan db:seed

# 5. Clear and cache config
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 6. Set proper permissions
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

#### 4. Security Considerations
- Use HTTPS in production
- Set proper file permissions
- Configure firewall rules
- Use environment variables for sensitive data
- Regular security updates
- Database backups

#### 5. Performance Optimization
- Enable OPcache
- Use Redis for cache and sessions
- Configure CDN for static assets
- Optimize database queries
- Enable gzip compression

## Troubleshooting

### Common Issues
1. **500 Error**: Check Laravel logs in `storage/logs/`
2. **Permission Issues**: Ensure storage and cache directories are writable
3. **Database Errors**: Verify database credentials and migrations
4. **HTTPS Issues**: Check SSL certificate configuration

### Useful Commands
```bash
# Check Laravel status
php artisan about

# Clear all caches
php artisan optimize:clear

# View logs
tail -f storage/logs/laravel.log

# Check database connection
php artisan tinker
> DB::connection()->getPdo();
```
