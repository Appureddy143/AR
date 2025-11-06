# Use the official PHP-Apache image
FROM php:8.2-apache

# Set working directory
WORKDIR /var/www/html

# Copy all project files into the container
COPY . /var/www/html/

# Enable Apache mod_rewrite (good for PHP routing)
RUN a2enmod rewrite

# Set permissions for Apache
RUN chown -R www-data:www-data /var/www/html

# Expose port 80 for HTTP traffic
EXPOSE 80

# Start Apache server
CMD ["apache2-foreground"]
