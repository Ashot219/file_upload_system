# Set the base image
FROM php:8.1-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev git zip libxml2-dev libicu-dev libonig-dev libssl-dev

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql mbstring bcmath xml intl opcache

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the working directory inside the container
WORKDIR /var/www

# Copy the Laravel application into the container
COPY . .

# Install the application dependencies
RUN composer install

# Expose port 9000 and start php-fpm
EXPOSE 9000
CMD ["php-fpm"]
