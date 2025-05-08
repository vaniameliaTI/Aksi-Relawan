FROM php:8.1-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nginx \
    libzip-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Configure PHP
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" && \
    sed -i 's/upload_max_filesize = 2M/upload_max_filesize = 10M/' "$PHP_INI_DIR/php.ini" && \
    sed -i 's/post_max_size = 8M/post_max_size = 10M/' "$PHP_INI_DIR/php.ini" && \
    sed -i 's/memory_limit = 128M/memory_limit = 256M/' "$PHP_INI_DIR/php.ini"


# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy existing application directory
COPY . /var/www/html

# Create upload directory and set permissions
RUN mkdir -p /var/www/html/uploads/profile_photos && \
    chmod -R 777 /var/www/html/uploads

# Copy Nginx configuration
COPY nginx.conf /etc/nginx/sites-available/default

# Create startup script
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Expose ports
EXPOSE 80 9000

# Start Nginx and PHP-FPM
ENTRYPOINT ["docker-entrypoint.sh"] 