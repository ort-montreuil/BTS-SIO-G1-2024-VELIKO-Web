<?php
#Ceci est un test pour voir si la base de donnée db est fonctionnelle. Elle ne l'est pas, il ya une erreur quelque part.
const DBHOST = 'db';
const DBUSER = 'test';
const DBPASS = "pass";
const DBNAME = "Veliko-demo";

$dsn = "mysql:host="+ DBHOST +";dbname=" + DBNAME;
try {
    $db = new PDO($dsn, DBUSER,DBPASS);
    echo "Connecté";

} catch (PDOException $exception){
    echo "Une erreur est survenue :" + $exception-> getMessage();
    die;
}

