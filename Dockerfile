FROM php:8.1-apache

# Install git and MySQL extensions for PHP
RUN apt-get update && apt-get install -y git
RUN docker-php-ext-install pdo pdo_mysql mysqli
RUN a2enmod rewrite

# Copy Apache config to allow .htaccess overrides and directory listings
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

# Set permissions for Apache
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

COPY src /var/www/html/
EXPOSE 80/tcp
EXPOSE 443/tcp