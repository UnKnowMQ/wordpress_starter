# Dockerfile
FROM php:8.3-fpm

# Cài extension mysqli và pdo_mysql
RUN docker-php-ext-install mysqli pdo pdo_mysql
