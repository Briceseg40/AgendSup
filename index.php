<?php

require_once 'include.php';

//Chargement du template
$template = $twig->load('index.twig');

echo $template->render();

?>

