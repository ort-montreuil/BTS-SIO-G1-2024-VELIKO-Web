## Ceci est la procédure d’installation d’un serveur Apache Ubuntu 20.04 avec SSL auto-signé

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

<h3>Etape 3, création du certificat SSL :</h3>

Nous pouvons créer les fichiers de clés et de certificats SSL avec la commande openssl :
>sudo openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout /etc/ssl/private/apache-selfsigned.key -out /etc/ssl/certs/apache-selfsigned.crt

<h3>Etape 4, Configuration d’Apache pour utiliser SSL:</h3>
> $ sudo nano /etc/apache2/sites-available/your_domain_or_ip.conf

> <VirtualHost *:443>
ServerName your_domain_or_ip
DocumentRoot /var/www/your_domain_or_ip
SSLEngine on
SSLCertificateFile /etc/ssl/certs/apache-selfsigned.crt
SSLCertificateKeyFile /etc/ssl/private/apache-selfsigned.key
</VirtualHost>

Nous allons maintenant créer notre DocumentRoot et y insérer un fichier HTML à des fins de test :
> $ sudo mkdir /var/www/your_domain_or_ip

Ouvrez un nouveau fichier index.html avec votre éditeur de texte :
> $ sudo nano /var/www/your_domain_or_ip/index.html

Collez ce qui suit dans le fichier vierge :
> <h1>it worked!</h1>

Enregistrez et fermez le fichier. Ensuite, nous devons activer le fichier de configuration avec l’outil a2ensite :
> $ sudo a2ensite your_domain_or_ip.conf

Ensuite, effectuons un test à la recherche d’éventuelles erreurs de configuration :
> $ sudo apache2ctl configtest
 
Si tout fonctionne correctement, vous obtiendrez un résultat qui ressemble à ceci :

> Output
AH00558: apache2: Could not reliably determine the server's fully qualified domain name, using 127.0.1.1. Set the 'ServerName' directive globally to suppress this message
Syntax OK

Nous pouvons recharger Apache en toute sécurité pour que nos modifications soient appliquées :
> $ sudo systemctl reload apache2

Chargez maintenant votre site dans un navigateur, en veillant à utiliser https:// au début.

si votre navigateur ne se connecte pas du tout au serveur, assurez-vous que votre connexion n’est pas bloquée par un pare-feu.
> $ sudo ufw allow "Apache Full"

<h3>Etape 5, Redirection de HTTP vers HTTPS</h3>

Mettons en place un VirtualHost pour répondre à ces demandes non cryptées et les rediriger vers le HTTPS.
Ouvrez le même fichier de configuration Apache que celui que nous avons lancé lors des étapes précédentes :
> $ sudo nano /etc/apache2/sites-available/your_domain_or_ip.conf
> <VirtualHost *:80>
ServerName your_domain_or_ip
Redirect / https://your_domain_or_ip/
</VirtualHost>

Enregistrez et fermez ce fichier lorsque vous avez terminé, puis testez à nouveau la syntaxe de votre configuration, et rechargez Apache :
>$ sudo apachectl configtest
$ sudo systemctl reload apache2

