<?php
/* @file controller_index.php
 * @brief Contrôleur pour la page de connexion.
 * @author Baptiste Marsaa
 * @date 19/11/2025
 */
class ControllerIndex extends Controller {
    // Constructeur
    /**
     * @brief Constructeur de la classe ControllerIndex.
     * @param \Twig\Loader\FilesystemLoader $loader Chargeur de fichiers Twig.
     * @param \Twig\Environment $twig Environnement Twig.
     */
    public function __construct(\Twig\Loader\FilesystemLoader $loader, \Twig\Environment $twig) {
        parent::__construct($loader, $twig);
    }
    /**
     * @brief Rendu de la page de connexion.
     */
    public function render() {
       $template = $this->getTwig()->load('login.html.twig');
       echo $template->render();
    }
} 
?>
