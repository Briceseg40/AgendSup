<?php

class ControllerClasseVirtuel extends Controller
{
    public function __construct(\Twig\Loader\FilesystemLoader $loader, \Twig\Environment $twig)
    {
        parent::__construct($loader, $twig);
    }

    public function salle()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?controleur=connecter&methode=connexion');
            exit();
        }

        $idClasse = $_GET['id'] ?? null;

        if (!$idClasse) {
            header('Location: index.php?controleur=joinClass&methode=render');
            exit();
        }

        // On peut passer l'ID à la vue pour savoir dans quelle salle on est
        echo $this->getTwig()->render('classeVirtuel.html.twig', [
            'idClasse' => $idClasse
        ]);
    }
}