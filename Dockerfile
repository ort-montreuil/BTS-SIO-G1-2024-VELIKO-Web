# Utiliser l'image officielle de PHP-FPM
FROM php:8.2-fpm

# Installer OpenSSL et PDO MySQL
RUN apt-get update && apt-get install -y \
    openssl \
    && docker-php-ext-install pdo_mysql

# Générer une clé privée et un certificat auto-signé pour veliko.local
RUN mkdir -p /etc/nginx/certs \
    && openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
    -keyout /etc/nginx/certs/veliko.local-key.pem \
    -out /etc/nginx/certs/veliko.local.pem \
    -subj "/CN=veliko.local"

# Copier les fichiers de certificat et clé dans le conteneur
COPY ./certs/veliko.local.pem /etc/nginx/certs/certificate.crt
COPY ./certs/veliko.local-key.pem /etc/nginx/certs/certificate.key

# Copier le fichier de configuration Nginx dans le conteneur
COPY ./nginx/site.conf /etc/nginx/conf.d/default.conf

# Copier le fichier fastcgi-php.conf dans le conteneur
COPY ./nginx/fastcgi-php.conf /etc/nginx/snippets/fastcgi-php.conf

# Copier le code source dans le conteneur
COPY ./www /var/www/html

# Définir les permissions appropriées
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod 644 /etc/nginx/certs/certificate.crt /etc/nginx/certs/certificate.key

# Exposer les ports pour PHP-FPM
EXPOSE 9000

# Commande de démarrage par défaut
CMD ["php-fpm"]
