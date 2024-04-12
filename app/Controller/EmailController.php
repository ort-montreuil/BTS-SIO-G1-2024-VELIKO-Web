<?php

namespace Controller;

use Studoo\EduFramework\Core\ConfigCore;
use Studoo\EduFramework\Core\Controller\ControllerInterface;
use Studoo\EduFramework\Core\Controller\Request;
use Studoo\EduFramework\Core\View\TwigCore;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class EmailController implements ControllerInterface
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

        var_dump(ConfigCore::getConfig(key: 'version'));
        return TwigCore::getEnvironment()->render('Email/monMail.html.twig',
            [
                'titre'   => "" ,
                'requete' => $request
            ]
        );
    }
}
