<?php

class ControllerJoin extends Controller {

    public function __construct(\Twig\Loader\FilesystemLoader $loader, \Twig\Environment $twig) {
        parent::__construct($loader, $twig);
    }

    public function render() {
       $template = $this->getTwig()->load('joinClass.html.twig');
       echo $template->render();
    }
} 
?>
