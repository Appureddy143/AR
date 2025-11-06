# Use PHP + Apache
FROM php:8.2-apache

# Working directory
WORKDIR /var/www/html

# Copy all files (PHP, models, images, CSS, JS)
COPY . /var/www/html/

# Enable Apache rewrite module
RUN a2enmod rewrite

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
