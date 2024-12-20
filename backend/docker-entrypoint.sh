# This file is for php-fpm (ignore if not relevant)
#!/bin/sh

# Run migrations
php artisan migrate --force

# Start PHP-FPM
php-fpm