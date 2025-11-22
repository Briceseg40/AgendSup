<?php

class ControllerConnecter extends Controller {

    public function __construct(\Twig\Loader\FilesystemLoader $loader, \Twig\Environment $twig) {
        parent::__construct($loader, $twig);
    }

    public function connexion() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['loginName'] ?? '';
            $password = $_POST['password'] ?? '';

            $pdo = Bd::getInstance()->getConnection();
            $etudiantDAO = new EtudiantDAO($pdo);
            $etudiant = $etudiantDAO->findByEmail($email);

            if ($etudiant && $password === $etudiant->getMdp()) {
                $_SESSION['user'] = $etudiant;
                header('Location: index.php?controleur=connecter&methode=render');
                exit();
            } else {
                echo $this->getTwig()->render('login.html.twig', ['error' => 'Identifiants incorrects']);
            }
        } else {
            echo $this->getTwig()->render('login.html.twig');
        }
    }

    public function deconnexion() {
        session_destroy();
        header('Location: index.php?controleur=connecter&methode=connexion');
        exit();
    }

    public function render() {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?controleur=connecter&methode=connexion');
            exit();
        }
        echo $this->getTwig()->render('connected.html.twig', ['user' => $_SESSION['user']]);
    }
}