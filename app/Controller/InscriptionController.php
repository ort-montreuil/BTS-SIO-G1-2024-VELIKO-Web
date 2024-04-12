<?php

namespace Controller;

use JetBrains\PhpStorm\NoReturn;
use PDO;
use Studoo\EduFramework\Core\Controller\ControllerInterface;
use Studoo\EduFramework\Core\Controller\Request;
use Studoo\EduFramework\Core\View\TwigCore;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class InscriptionController implements ControllerInterface
{
	public function execute(Request $request): string|null
	{




        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'] ?? '';
            $prenom = $_POST['prenom'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($nom) || empty($prenom) || empty($email) || empty($password)){
                return "Veuillez remplir tout les champs";
            }


            if (strlen($password) < 8 || !preg_match("/[A-Z]/", $password) ||
                !preg_match("/[a-z]/", $password) ||
                !preg_match("/[0-9]/", $password) ||
                !preg_match("/[^A-Za-z0-9]/", $password)||
                !preg_match("/[@]/", $email)||
                !preg_match("/[.]/", $email)){
                // message d'erreur
                return "<center><h1>Adresse e-mail ou le mot de passe n'est pas conforme aux critères </h1> <br> 
                        <a href='/inscription'>Veuillez Ressayez</a> </center";
            }

// Si le mot de passe est valide
            $password_hache = password_hash($password, PASSWORD_DEFAULT);
            $this->insertUser($nom, $prenom, $email, $password_hache);
            header("Location: /encrypt");
            exit();




        }






		return TwigCore::getEnvironment()->render('inscription/inscription.html.twig',
		    [
		        "titre"   => 'Bienvenue',
		        "request" => $request
		    ]
		);




	}
    /**
     * @param string $nom
     * @param string $prenom
     * @param string $email
     * @param string $password_hache
     * @return void
     */

    #[NoReturn] private function insertUser(string $nom, string $prenom, string $email, string $password_hache): void{
        // Connexion 
        $bdd = new PDO('mysql:host=localhost;dbname=TestCyb', 'root', 'root');

        //  si le mail existe déjà dans la base de données
        $stmt = $bdd->prepare("SELECT COUNT(*) FROM Utilisateur WHERE email = ?");
        $stmt->execute([$email]);
        $result = $stmt->fetchColumn();

        if ($result > 0) {
            //message d'erreur à l'utilisateur
            header("Location: /monMail");
            exit();
        }

        //requête d'insertion
        $stmt = $bdd->prepare("INSERT INTO Utilisateur (nom, prenom, email, password) VALUES (?, ?, ?, ?)");

        // Exécution requête
        $stmt->execute([$nom, $prenom, $email, $password_hache]);

        //inscription réussie
        header("Location: /encrypt");
        exit();
    }


}
