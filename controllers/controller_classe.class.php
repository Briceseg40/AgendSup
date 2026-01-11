<?php
/* @file controller_classe.class.php
* @author Rémi Bouillon
* @brief Contrôleur pour la gestion des classes.
* @details Ce contrôleur gère les opérations liées aux classes,
* telles que l'affichage de la liste des classes.
* @version 0.1
* @date 19/11/2025
*/
class controller_classe extends Controller
{
    // Constructeur
    /**
     * @brief Constructeur de la classe controller_classe.
     * @param \Twig\Loader\FilesystemLoader $loader Chargeur de fichiers Twig.
     * @param \Twig\Environment $twig Environnement Twig.
     */
    public function __construct(\Twig\Loader\FilesystemLoader $loader, \Twig\Environment $twig)
    {
        parent::__construct($loader, $twig);
    }

    /**
     * @brief Liste toutes les classes.
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