<?php
class controller_clase extends Controller
{
    public function __construct(\Twig\Loader\FilesystemLoader $loader, \Twig\Environment $twig)
    {
        parent::__construct($loader, $twig);
    }

    public function lister(): void
    {
        $manager = new ClasseDAO($this->getPdo());
        $classes = $manager->findAll();

        //Chargement du template
        $template = $this->getTwig()->load('index.twig');

        //Affichage du template et transmission des données
        echo $template->render(array(
            'classes' => $classes,
        ));
    }
}