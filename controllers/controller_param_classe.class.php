<?php
/**
 * @file controller_param_classe.class.php
 * @brief Contrôleur pour la gestion de la page des paramètres de classe.
 *
 * Ce contrôleur permet d'afficher la page des paramètres de classe
 * via un template Twig.
 */ 

class ControllerParamClasse extends Controller {
    //Constructeur
    /**
     * @brief Constructeur du contrôleur des paramètres de classe.
     *
     * @param \Twig\Loader\FilesystemLoader $loader Chargeur de templates Twig.
     * @param \Twig\Environment $twig Environnement Twig.
     */
    public function __construct(\Twig\Loader\FilesystemLoader $loader, \Twig\Environment $twig) {
        parent::__construct($loader, $twig);
    }

    //Render
    /**
     * @brief Affiche la page des paramètres de classe.
     */
    public function render() {
        echo $this->getTwig()->render('ParamClass.html.twig');
    }

    
}
