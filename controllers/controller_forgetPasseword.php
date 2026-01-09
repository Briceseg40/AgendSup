<?php
//Il faut hasher le mdp
/**
 * @file controller_forgetPasseword.php
 * @brief Contrôleur pour la gestion de la page de mot de passe oublié.
 *
 * Ce contrôleur permet d'afficher la page de réinitialisation du mot de passe
 * via un template Twig.
 */
class ControllerForgetPasseword extends Controller {
    //Constructeur
    /**
     * @brief Constructeur du contrôleur de mot de passe oublié.
     *
     * @param \Twig\Loader\FilesystemLoader $loader Chargeur de templates Twig.
     * @param \Twig\Environment $twig Environnement Twig.
     */
    public function __construct(\Twig\Loader\FilesystemLoader $loader, \Twig\Environment $twig) {
        parent::__construct($loader, $twig);
    }

    //Render
    /**
     * @brief Affiche la page de mot de passe oublié.
     */
    public function render() {
        echo $this->getTwig()->render('forgetPasseword.html.twig');
    } 
}