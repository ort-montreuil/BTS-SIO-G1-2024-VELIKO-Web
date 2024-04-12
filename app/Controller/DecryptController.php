<?php

namespace Controller;

use Studoo\EduFramework\Core\Controller\ControllerInterface;
use Studoo\EduFramework\Core\Controller\Request;
use Studoo\EduFramework\Core\View\TwigCore;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class DecryptController implements ControllerInterface
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
        if ($_SERVER["REQUEST_METHOD"]== "POST" ){
            if (isset($_POST["decry"]) && !empty($_POST["decry"])){
                $text = $_POST["decry"];
                $decrypt = base64_decode($text);
            }
        }




        return TwigCore::getEnvironment()->render('decrypt/monMail.html.twig',
            [
                'titre'   => 'Decrypt Formulaire',
                'requete' => $request,
                'decoder' => $decrypt,
            ]
        );
    }
}
