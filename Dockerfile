# Utiliser l'image officielle de PHP-FPM
FROM php:7.4-fpm

# Installer OpenSSL
RUN apt-get update && apt-get install -y \
    openssl \
    && docker-php-ext-install pdo_mysql

# Copier le code source dans le conteneur
COPY ./www /var/www/html

# Définir les permissions appropriées
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

