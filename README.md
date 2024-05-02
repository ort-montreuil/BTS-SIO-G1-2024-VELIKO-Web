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