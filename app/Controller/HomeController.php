<?php

namespace Controller;

use PDO;
use Studoo\EduFramework\Core\Controller\ControllerInterface;
use Studoo\EduFramework\Core\Controller\Request;
use Studoo\EduFramework\Core\Service\DatabaseService;
use Studoo\EduFramework\Core\View\TwigCore;
use Symfony\Component\Console\Input\Input;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
class HomeController implements ControllerInterface
{
    /**
     * @param Request $request Requête HTTP
     * @return string|null
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function execute(Request $request): string|null
    {


            $bdd = new PDO('mysql:host=localhost;dbname=TestCyb', 'root', 'moussa');
            $prenom = $_SESSION['prenom'] ?? 'Invité';
            $nom = $_SESSION['nom'];





        return TwigCore::getEnvironment()->render('home/home.html.twig',
            [
                'titre'   => 'Map',
                'requete' => $request,
                'prenom' =>  $prenom,
                'nom'    => $nom

            ]
        );
    }
}
