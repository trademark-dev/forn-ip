# PHP 8.2 aur Apache install karo
FROM php:8.2-apache

# Required extensions install karo (mysqli, pdo_mysql)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Apache ke liye mod_rewrite enable karo (CodeIgniter ke liye zaroori hai)
RUN a2enmod rewrite

# CodeIgniter ka "public" folder as DocumentRoot set karo
WORKDIR /var/www/html

# Sabhi files Docker container me copy karo
COPY . /var/www/html

# Apache expose karo (80 port)
EXPOSE 80

# Apache service start karo
CMD ["apache2-foreground"]
