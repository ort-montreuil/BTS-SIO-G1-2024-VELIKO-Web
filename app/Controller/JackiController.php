<?php

namespace Controller;

use Studoo\EduFramework\Core\Controller\ControllerInterface;
use Studoo\EduFramework\Core\Controller\Request;
use Studoo\EduFramework\Core\Service\DatabaseService;
use Studoo\EduFramework\Core\View\TwigCore;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class JackiController implements ControllerInterface
{
	public function execute(Request $request): string|null
	{

        $connect = DatabaseService::getConnect();
        //création d'un nouveau nom
        if ($request->get('nom') != null){
            $connect->query(query: "INSERT INTO user (id,nom) VALUES (NULL,'".$request->get('nom')."');");
        }
        //supprimer un utilisateur
        if ($request->get('user_id') != null){
            $connect->query(query: "DELETE FROM user WHERE user.id = " . $request->get("user_id"));
        }



        $statement = $connect->query(query: "SELECT * FROM user");

        $users = $statement->fetchAll();



		return TwigCore::getEnvironment()->render('jacki/jacki.html.twig',
		    [
		        "titre"=> 'JackiController',
		        "request"=> $request,
                "listeusers"=>$users

		    ]
		);
	}
}
