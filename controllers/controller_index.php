<?php
/**
 * @file controller_index.php
 * @brief Contrôleur pour la gestion de la page de connexion.
 *
 * Ce contrôleur permet d'afficher la page de connexion
 * via un template Twig.
 */
class ControllerIndex extends Controller {
    //Constructeur
    /**
     * @brief Constructeur du contrôleur de la page de connexion.
     *
     * @param \Twig\Loader\FilesystemLoader $loader Chargeur de templates Twig.
     * @param \Twig\Environment $twig Environnement Twig.
     */
    public function __construct(\Twig\Loader\FilesystemLoader $loader, \Twig\Environment $twig) {
        parent::__construct($loader, $twig);
    }
    
    //Render   
    /**
     * @brief Affiche la page de connexion.
     */
    public function render() {
       $template = $this->getTwig()->load('login.html.twig');
       echo $template->render();
    }
} 
?>
