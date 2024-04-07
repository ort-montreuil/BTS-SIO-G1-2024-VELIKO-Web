<?php

namespace Controller;

use Studoo\EduFramework\Core\Controller\ControllerInterface;
use Studoo\EduFramework\Core\Controller\Request;
use Studoo\EduFramework\Core\Service\DatabaseService;
use Studoo\EduFramework\Core\View\TwigCore;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class HelloController implements ControllerInterface
{
    public function execute(Request $request): string|null
    {
        //request gerer l'ensemble des requette http

        $statCrud ='create';
        $user=null;





        $connect = DatabaseService::getConnect();
        //création d'un nouveau nom
        if ($request->get("statCrud")=="create"&&$request->getHttpMethod()=="POST"&& $request->get('nom') != null){
            $connect->query(query: "INSERT INTO user (id,nom) VALUES (NULL,'".$request->get('nom')."');");
        }




        //ici on fais une requete qui supprimer un utilisateur quand on appuie sur supprimer
        //$statCrud est une variable que nous avons crée le nom importe peu on aurai pu mettre n'importe quoi
        //en haut on l'a mis egale a create c'est sa valeur par default
        //$request->get("statCrud")=="supprimer" on met cette ligne au debut pour dire cette commande servivera a supprimer
        //car si on le fais pas quand on appuiera sur supprimer c'est la requete d'en haut qui s'executera c'est pour sa que
        //dans chaque ligne avant de commencer une requete on met $request->get("statCrud")=="supprimer" et on spécifie ici "supprimer"
        //car dans le html il y'a un long lien <a href="..... dedans on appelle supprimer en gros et on fais la meme chose pour les deux dernier
        //pour faire simple la requete sert a supprimer donc on met supprimer ici et dans le html, ensuite l'autre servira a update donc on fais pareil
        if ($request->get("statCrud")=="supprimer"&&$request->getHttpMethod()=="GET"&& $request->get('user_id') != null){
            $connect->query(query: "DELETE FROM user WHERE user.id = " . $request->get("user_id"));
        }


        //ici  fais une requte pour afficher les user dans le input quand on appuiera sur Update dans la page
        if ($request->get("stateCrud")=="update"&&$request->getHttpMethod()=="POST"&&$request->get('user_id')!=null) {
            $statement = $connect->query(query: "SELECT * FROM user");
            ;$user = var_dump($statement->fetch());
        }

        // ici c'est la requete qui sert a Modifier un utilisateur
        if ($request->get("stateCrud")=="update"&&$request->getHttpMethod()=="POST"&&$request->get('user_id')!=null) {
            $connect->query("UPDATE user SET user.nom = '" . $request->get('user_id') . "' WHERE id = " . $request->get('user_id'));
        }


        //pour faire une requette sa commence toujours pareil on fais une condition et une confition c'est un if(....){.......}
        // c'est toujours construit de la meme maniere
        //request c'est pour gerer toute les requte
        //connect->query(ta requete sql) c'est pour ecrire ta requete sql






        $statement = $connect->query(query: "SELECT * FROM user");

        $users = $statement->fetchAll();





        return TwigCore::getEnvironment()->render('hello/hello.html.twig',
            [
                "titre"   => 'HelloController',
                "request"=> $request,
                "listeusers"=>$users,
                "statCrud" => $statCrud,
                "user" => $user

            ]
        );
    }
}

