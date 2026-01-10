<?php

class ControllerJoinClass extends Controller {

    public function __construct(\Twig\Loader\FilesystemLoader $loader, \Twig\Environment $twig) {
        parent::__construct($loader, $twig);
    }

    public function render() {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?controleur=connecter&methode=connexion');
            exit();
        }
        $utilisateurConnecte = $_SESSION['user'];

        $idEtudiant = $utilisateurConnecte->getId();

        $pdo = Bd::getInstance()->getConnection();
        $classeDAO = new ClasseDAO($pdo);
        $listeDesClasses = $classeDAO->findPerso($idEtudiant);

        echo $this->getTwig()->render('joinClass.html.twig', [
            'classes' => $listeDesClasses
        ]);
    }
} 
?>
 