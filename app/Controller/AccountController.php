<?php

namespace Controller;

use PDO;
use Studoo\EduFramework\Core\Controller\ControllerInterface;
use Studoo\EduFramework\Core\Controller\Request;
use Studoo\EduFramework\Core\View\TwigCore;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class AccountController implements ControllerInterface
{
	public function execute(Request $request): string|null
	{

        $bdd = new PDO('mysql:host=localhost;dbname=TestCyb', 'root', 'moussa');
        $prenom = $_SESSION['prenom'] ?? 'Invité';
        $nom = $_SESSION['nom'];






		return TwigCore::getEnvironment()->render('account/account.html.twig',
		    [
		        "titre"   => 'Votre profil',
		        "request" => $request,
                "prenom"  => $prenom,
                "nom"     => $nom


		    ]
		);
	}
}
