<?php

class ControllerConnecter extends Controller {

    public function __construct(\Twig\Loader\FilesystemLoader $loader, \Twig\Environment $twig) {
        parent::__construct($loader, $twig);
    }

    public function render() {
       $template = $this->getTwig()->load('connected.html.twig');
       echo $template->render();
    }
}
