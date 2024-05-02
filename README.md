## Bienvenu dans votre projet avec Edu-Framework

> [!NOTE]
> Pour installation et la configuration, voir -> [https://edu-framework.studoo.app/](https://edu-framework.studoo.app/)

## Ceci est la procédure d’installation d’un serveur Apache avec SSL auto-signé 

<h3>Etape 1, installation de Apache :</h3>
Dans un premier temps, il faut installer Apache : 
> $ sudo apt update

Ensuite, installez le paquet apache2 :

> $ sudo apt install apache2

On ouvre les ports en cas d'installation de pare-feu :
> $ sudo ufw allow "Apache Full"

<h3>Etape 2, activation de mod_ssl :</h3>
Activez mod_ssl à l’aide de la commande a2enmod :
> $ sudo a2enmod ssl

Redémarrez Apache pour activer le module :
> $ sudo systemctl restart apache2

Le module mod_ssl est maintenant activé et prêt à l’emploi.

<h3>Etape 3, Création du certificat SSL :</h3>
> $ sudo openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout /etc/ssl/private/apache-selfsigned.key -out /etc/ssl/certs/apache-selfsigned.crt