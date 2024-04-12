<?php

namespace Controller;

use Studoo\EduFramework\Core\Controller\ControllerInterface;
use Studoo\EduFramework\Core\Controller\Request;
use Studoo\EduFramework\Core\View\TwigCore;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class EncryptController implements ControllerInterface
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
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["inputText"]) && !empty($_POST["inputText"])) {
                $texte = $_POST["inputText"];
                $texte_crypte = base64_encode($texte);



            }
        }



        return TwigCore::getEnvironment()->render('encrypt/Encrypt.html.twig',
            [
                'titre'   => 'Encrypt Formulaire',
                'requete' => $request,
                'reponse'=> $texte_crypte,
            ]
        );
    }
}
