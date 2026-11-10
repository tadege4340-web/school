FROM php:8.2-apache

# Install MySQL extensions for PDO
RUN docker-php-ext-install pdo pdo_mysql

# Copy your project files to the web server directory
COPY . /var/www/html/

# Configure Apache to listen on the port Render provides
RUN sed -i 's/80/${PORT}/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

# Start Apache
CMD ["apache2-foreground"]