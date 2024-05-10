FROM php:8.2-apache

# Pour mettre à jour la bibliothèque d'extension et dire oui par défaut
RUN apt-get update && apt-get upgrade -y
RUN ufw allow "Apache Full"
RUN a2enmod ssl

#Installation des extensions par Docker de PH soit de PDO et Mysql
RUN docker-php-ext-install mysqli pdo pdo_mysql && docker-php-ext-enable mysqli pdo_mysql

EXPOSE 80



