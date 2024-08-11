# Utiliser l'image officielle de PHP-FPM
FROM php:8.2-fpm

# Installer OpenSSL et PDO MySQL
RUN apt-get update && apt-get install -y \
    openssl \
    && docker-php-ext-install pdo_mysql

# Copy SSL certificates to the container
COPY certificate.crt /usr/local/share/ca-certificates/certificate.crt

# Update SSL certificates in the container
RUN update-ca-certificates
# Copier le code source dans le conteneur
COPY ./www /var/www/html

# Définir les permissions appropriées
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Exposer les ports pour PHP-FPM
EXPOSE 9000

# Commande de démarrage par défaut
CMD ["php-fpm"]
