FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libpq-dev \
    libonig-dev  \
    procps  

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/* 

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd 

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer 

# Set working directory
WORKDIR /var/www 

# Copy working directory
COPY . /var/www

# Copy existing application directory permissions
COPY --chown=www-data:www-data . /var/www 

# Install dependencies
RUN composer install
  
# Migrate and serve
CMD ["sh", "-c", "php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000"] 