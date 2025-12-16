<?php
//Il faut hasher le mdp, 
class ControllerParamClasse extends Controller {

    public function __construct(\Twig\Loader\FilesystemLoader $loader, \Twig\Environment $twig) {
        parent::__construct($loader, $twig);
    }

    public function render() {
        echo $this->getTwig()->render('ParamClass.html.twig');
    }

    
}
