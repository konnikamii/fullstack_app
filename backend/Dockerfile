FROM php:8.2-cli
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
RUN apt-get clean && rm -rf /var/lib/apt/lists/* 
RUN docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd 
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer 
WORKDIR /var/www 
COPY . /var/www 
COPY --chown=www-data:www-data . /var/www 
RUN composer install
 

CMD ["sh", "-c", "php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000"]
# CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]