<?php
/**
 * @file controller_classe.php
 * @brief Contrôleur de gestion des classes.
 *
 * Ce contrôleur permet de gérer les actions liées aux classes,
 * notamment l'affichage de la liste des classes via Twig.
 */

/**
 * @class controller_classe
 * @brief Contrôleur des classes.
 *
 * Hérite de la classe Controller.
 * Gère les actions liées aux classes (liste, affichage, etc.).
 */
class controller_classe extends Controller
{
    /**
     * @brief Constructeur du contrôleur des classes.
     *
     * @param \Twig\Loader\FilesystemLoader $loader Chargeur de templates Twig.
     * @param \Twig\Environment $twig Environnement Twig.
     */
    public function __construct(\Twig\Loader\FilesystemLoader $loader, \Twig\Environment $twig)
    {
        parent::__construct($loader, $twig);
    }

    /**
     * @brief Affiche la liste des classes.
     *
     * Récupère toutes les classes via le DAO et les affiche
     * en utilisant un template Twig.
     */
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