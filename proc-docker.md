## Documentation Docker

<h2>Installation du service Apache2</h2>
>apt update

>apt upgrade -y

>apt install apache2 apache2-utils -y

>service apache2 start

>a2enmod rewrite // Active la réécriture d'url

>a2enmod deflate // gestion de la compression, notamment en gzip, pour utiliser la mise en cache des pages sur votre site

>a2enmod headers // Afin de pouvoir agir sur les en-têtes HTTP

>a2enmod ssl     // pour gérer les certificats SSL et protocole HTTPS

>service apache2 restart

<h2>Installation de PHP</h2>
>apt install -y php

<h4>Etape 2, Ajout des modules complémentaires de PHP :</h4>
>apt install libapache2-mod-php php-cli php-fpm php-json php-pdo php-mysql php-zip php-gd php-mbstring php-curl php-xml php-pear php-bcmath php-readline

<h4>Etape 3, Verification de la version</h4>
>php -v

<h4>Etape 4, Redémarrage du service apache2</h4>
>service apache2 restart
ou
>systemctl apache2 restart

<h4>Etape 5,Création d’une page phpinfo</h4>
>sudo nano /var/www/html/phpinfo.php
<?php phpinfo(); ?>

<h4>Etape 6, Création d’une page index.php</h4>
>sudo nano /var/www/html/index.php

<?php echo "<h1>Hello !</h1>"; ?>

<h4>Etape 7, Enfin, supprimez la page d'accueil d'origine d'Apache.</h4>
>sudo rm /var/www/html/index.html

<h4> Etape 8, Modifications sur la configuration Apache2 :</h4>
Pour sécuriser un serveur Apache2, la première étape à faire sur un serveur Apache2. C’est de cacher la version du service.

 Accéder au fichier :

> sudo nano /etc/apache2/conf-enabled/security.conf

> Remplacer : ServerSignature On

> Par : ServerSignature Off

La seconde étape de sécurisation du serveur Apache2 sera de désactiver la lisibilité des fichiers présents dans les dossiers :

Accéder au fichier :
> sudo nano /etc/apache2/conf-enabled/security.conf

Ajouter la directive ci dessous,
cette dernière peut aussi être ajouter dans le fichier vhost.conf

><Directory /var/www>
		Options -Indexes
</Directory>

Enfin on redémarre le service apache2 :
> service apache2 restart

<h2>Installation du WAF Apache Mod Security</h2>
<h3> Etape 1, Installation du package</h3>
> sudo apt install libapache2-mod-security2 -y

<h3> Etape 2, Activation du module</h3>

> sudo a2enmod security2

<h3> Etape 3, Redémarrage du service apache2</h3>

> sudo service apache2

ou 

> sudo systemctl restart apache2

<h3> Etape 4,Configuration de ModSecurity</h3>
Le fichier de configuration du module apache Security2 /etc/apache2/mods-enabled/security2.conf contient la ligne suivante, qui définit les fichiers optionnels de configuration que ModSecurity va charger :

> IncludeOptional /etc/modsecurity/*.conf

<h3>Activation du fichier de configuration de ModSecurity</h3>

> on renomme le fichier modsecurity.conf-recommended en : modsecurity.conf
sudo mv /etc/modsecurity/modsecurity.conf-recommended /etc/modsecurity/modsecurity.conf

<h3>Nous pouvons maintenant éditer ce fichier et y apporter les modifications suivantes :</h3>

> sudo nano /etc/modsecurity/modsecurity.conf

> #Modifications
On passe le moteur de security du mode détection simple au mode actif
SecRuleEngine DetectionOnly --> SecRuleEngine On

> Ici on peut formater les logs générer par ModSecurity, 
chaque lettre faisant référence à des informations particulière sur la requête bloquée

> ( Détails ci-dessous )
SecAuditLogParts ABDEFHIJZ --> SecAuditLogParts ABCEFHKJZ


<h3>Mise à jour du coreruleset de ModSecurity</h3>
<h4>Par défaut, Modsecurity embarque un jeu de règles permettant de nous protéger des OWASP ( les principales failles du Web), cependant il est possible de maintenir à jour ces règles en téléchargeant en installant la dernière version de ces règles.</h4>

<h4> Etape 1,Téléchargement du package</h4>

> wget https://github.com/coreruleset/coreruleset/archive/v4.0.0.tar.gz

<h4> Etape 2,Extraction des fichiers</h4> 

>tar xvf v4.0.0.tar.gz

<h4> Etape 3,Création du dossier dans /etc/apache2 et déplacement</h4> 

> sudo mkdir /etc/apache2/modsecurity-crs/

> sudo mv coreruleset-4.0.0/ /etc/apache2/modsecurity-crs/

<h4> Etape 4,On renomme le fichier crs-setup.conf.example en crs-setup.conf</h4>

> cd /etc/apache2/modsecurity-crs/coreruleset-4.0.0

> sudo mv crs-setup.conf.example crs-setup.conf

<h4> Etape 5,On retourne editer le fichier de conf du module apache2</h4>

> sudo nano /etc/apache2/mods-enabled/security2.conf

on remplace la ligne suivante

> IncludeOptional /usr/share/modsecurity-crs/*.load

Par :

>IncludeOptional /etc/apache2/modsecurity-crs/coreruleset-4.0.0/crs-setup.conf

>IncludeOptional /etc/apache2/modsecurity-crs/coreruleset-4.0.0/rules/*.conf

<h4> Etape 6, On redémarre :</h4>

> sudo apache2ctl -t

> sudo service apache2 restart


<h2>Installer un serveur de base de données MariaDb / Mysql</h2>

<h4>Etape 1, Mise à jour du système :</h4>

>apt update

> apt upgrade -y

<h4>Etape 2, installation :</h4>
>apt install -y mariadb-server

<h4>Etape 3, Démarrage du service :</h4>

>service mariadb start

<h4>Etape 4, Installation et configuration des accès à la base de données :</h4>
>mariadb-secure-installation

>#Enter current password for root (enter for none):

>#Change the root password? [Y/n] Y

>#New password:

>#Re-enter new password:

>#Remove anonymous users? [Y/n] Y

>#Disallow root login remotely? [Y/n] Y

>#Remove test database and access to it? [Y/n] Y

>#Reload privilege tables now? [Y/n] Y

<h4>Etape 5, Redémarrage du service :</h4>
>service mariadb restart

<h4>Etape 6, Connexion avec l’utilisateur root à la base de données :</h4>
>mysql -u root -p

<h2>Installation de PHPMYADMIN
<h4>Etape 1, installation :</h4>
>apt install apache2 php libapache2-mod-php php-cli php-mysql php-zip php-curl php-xml wget -y

>apt install phpmyadmin