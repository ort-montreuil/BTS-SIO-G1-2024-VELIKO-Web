<?php

namespace Controller;

use PDO;
use Studoo\EduFramework\Core\Controller\ControllerInterface;
use Studoo\EduFramework\Core\Controller\Request;
use Studoo\EduFramework\Core\View\TwigCore;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class ConnexionController implements ControllerInterface
{
    public function execute(Request $request): string|null
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                return "Veuillez remplir le champs";
            }

            // Connexion à la base de données
            $bdd = new PDO('mysql:host=localhost;dbname=TestCyb', 'root', 'root');

            // Requête pour récupérer l'utilisateur par son email
            $stmt = $bdd->prepare("SELECT * FROM Utilisateur WHERE email = ?");
            $stmt->execute([$email]);
            //ici on recupere les requete SQL avec la methode fetch
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Vérification du mot de passe
            if ($user && password_verify($password, $user['password'])) {
                // L'utilisateur est authentifié, rediriger vers une page protégée
                header("Location: /home");
                exit();
            } else {
                // Identifiants invalides, afficher un message d'erreur
                return "<center><h1>Adresse e-mail ou mot de passe incorrect</h1> <br> 
                        <a href='/connexion'>Veuillez Ressayez</a> </center";

            }
        }

        return TwigCore::getEnvironment()->render('connexion/connexion.html.twig',
            [
                "titre" => 'Bienvenue',
                "request" => $request
            ]
        );
    }
}



