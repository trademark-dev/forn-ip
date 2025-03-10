# PHP image use karo
FROM php:8.2-apache

# Required modules install karo (CodeIgniter ke liye)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Public folder ko expose karo (CodeIgniter ke liye)
WORKDIR /var/www/html

# Local files ko Docker container me copy karo
COPY . /var/www/html

# Apache enable karo
EXPOSE 80

# Apache start command
CMD ["apache2-foreground"]
