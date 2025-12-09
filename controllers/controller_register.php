<?php
//Il faut hasher le mdp, 
class ControllerRegister extends Controller {

    public function __construct(\Twig\Loader\FilesystemLoader $loader, \Twig\Environment $twig) {
        parent::__construct($loader, $twig);
    }

    public function createAccount() {
        
    }

    public function render() {
        echo $this->getTwig()->render('register.html.twig');
    }

    
}