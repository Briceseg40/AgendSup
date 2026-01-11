<?php
/* @file controller_forgetPasseword.php
 * @brief Contrôleur pour la page de mot de passe oublié.
 * @author Baptiste Marsaa
 * @date 19/11/2025
 */
class ControllerForgetPasseword extends Controller {
    /**
     * @brief Constructeur de la classe ControllerForgetPasseword.
     * @param \Twig\Loader\FilesystemLoader $loader Chargeur de fichiers Twig.
     * @param \Twig\Environment $twig Environnement Twig.
     */
    public function __construct(\Twig\Loader\FilesystemLoader $loader, \Twig\Environment $twig) {
        parent::__construct($loader, $twig);
    }
    /**
     * @brief Rendu de la page de mot de passe oublié.
     */
    public function render() {
        echo $this->getTwig()->render('forgetPasseword.html.twig');
    }

    
}