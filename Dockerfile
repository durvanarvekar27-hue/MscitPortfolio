FROM php:8.2-apache

# Copy your project files into the Apache document root
COPY . /var/www/html/

# Expose port 80
EXPOSE 80