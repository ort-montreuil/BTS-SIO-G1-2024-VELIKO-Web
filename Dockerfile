FROM php:8.2-apache

# Apache
RUN a2enmod rewrite
RUN service apache2 restart

EXPOSE 80