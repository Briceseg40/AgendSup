<?php

require_once '../vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('../templates');

$twig = new \Twig\Environment($loader);

$variables = [
    'page_title' => 'AgendSup'
];

echo $twig->render('base.html.twig', $variables);
echo $twig->render('home.html.twig', $variables);