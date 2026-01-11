<?php

class ControllerConnecter extends Controller {

    public function __construct(\Twig\Loader\FilesystemLoader $loader, \Twig\Environment $twig) {
        parent::__construct($loader, $twig);
    }

    public function connexion() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['loginName'] ?? '';
            $password = $_POST['password'] ?? '';
    
            // 1. Initialiser le DAO (assurez-vous d'avoir accès à $pdo ici)
            // Si votre architecture le permet, récupérez l'instance PDO existante
            $etudiantDAO = new EtudiantDAO($this->getPdo()); 
    
            // 2. Chercher l'étudiant par son mail
            $etudiant = $etudiantDAO->findByEmail($email);
    
            // 3. Vérifier si l'étudiant existe ET si le mot de passe est correct
            if ($etudiant && password_verify($password, $etudiant->getMdp())) {
                $_SESSION['authentifie'] = true;
                
                // REMPLACEZ VOTRE TABLEAU PAR L'OBJET COMPLET
                $_SESSION['user'] = $etudiant; 
            
                header('Location: index.php?controleur=connecter&methode=render');
                exit();
            }else {
                // Si l'étudiant n'existe pas ou mdp incorrect
                echo $this->getTwig()->render('login.html.twig', ['erreur' => 'Email ou mot de passe incorrect.']);
            }
        } else {
            echo $this->getTwig()->render('login.html.twig');
        }
    }
    

    public function deconnexion() {
        session_destroy(); //
        header('Location: index.php?controleur=connecter&methode=connexion');
        exit();
    }

    public function render() {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?controleur=connecter&methode=connexion');
            exit();
        }

        echo $this->getTwig()->render('connected.html.twig', [
            'user' => $_SESSION['user']
        ]);
    }
}