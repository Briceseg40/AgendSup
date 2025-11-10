<?php


class controllerCours extends Controller
{
    public function __construct(\Twig\Loader\FilesystemLoader $loader, \Twig\Environment $twig)
    {
        parent::__construct($loader, $twig);
    }

    public function lister(): void
    {
        $manager = new CoursDao($this->getPdo());
        $cours = $manager->findAll();

        //Chargement du template
        $template = $this->getTwig()->load('index.twig');

        //Affichage du template et transmission des données
        echo $template->render(array(
            'categories' => $cours,
        ));
    }

    public function listerByAgenda($id_Agenda): void
    {
        $manager = new CoursDao($this->getPdo());
        $cours = $manager->findByAgenda($id_Agenda);

        //Chargement du template
        $template = $this->getTwig()->load('index.twig');

        //Affichage du template et transmission des données
        echo $template->render(array(
            'cours' => $cours,
            'menu' => "category"
        ));
    }
}
