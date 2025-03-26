# Use official PHP Apache image
FROM php:8.1-apache

# Install additional dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    curl \
    && docker-php-ext-install zip

# Enable Apache mod_rewrite (if needed)
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy application source code
COPY . /var/www/html

# Set file permissions
RUN chown -R www-data:www-data /var/www/html

# Expose port 80 for Apache
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
