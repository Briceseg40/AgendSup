<?php
/* @file controller_classe.class.php
* @author Brice Seguret
* @brief Contrôleur pour la gestion des classes.
* @details Ce contrôleur gère les opérations liées aux classes,
* telles que l'affichage de la liste des classes.
* @version 0.1
* @date 19/11/2025
*/
class ControllerClasseVirtuel extends Controller
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

    
}