FROM php:8.2-apache

# Install MySQL extension
RUN docker-php-ext-install mysqli pdo_mysql

# Enable Apache rewrite module
RUN a2enmod rewrite

# Copy all files to Apache document root
COPY . /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

EXPOSE 80