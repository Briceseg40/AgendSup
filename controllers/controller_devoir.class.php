<?php

class ControllerDevoir extends Controller{

    public function __construct(\Twig\Loader\FilesystemLoader $loader, \Twig\Environment $twig)
    {
        parent::__construct($loader, $twig);
    }

    //Afficher
    public function afficher(): void
    {
        $manager = new DevoirDAO($this->getPdo());
        $devoir = $manager->findAll();

        $template = $this->getTwig()->load('devoir/afficher.twig');

        echo $template->render([
            'categories' => $devoir,
        ]);
    }

    //Lister
    public function lister(): void
    {
        $template = $this->getTwig()->load('devoir/lister.twig');

        echo $template->render([
            "titre" => "Liste des devoirs"
        ]);
    }

    //Creer
    public function creer(): void
    {
        $template = $this->getTwig()->load('devoir/creer.twig');

        echo $template->render([
            "titre" => "Créer un devoir"
        ]);
    }

    //Modifier
    public function modifier(): void
    {
        $template = $this->getTwig()->load('devoir/modifier.twig');

        echo $template->render([
            "titre" => "Modifier un devoir"
        ]);
    }

    //Supprimer
    public function supprimer(): void
    {
        $template = $this->getTwig()->load('devoir/supprimer.twig');

        echo $template->render([
            "titre" => "Supprimer un devoir"
        ]);
    }
}
