<?php

// require_once 'include.php';

// $db = Bd::getInstance();
// $pdo = $db->getConnection();

// $agendaManager = new AgendaDAO($pdo);
// $agendas = $agendaManager->findAll();
// $coursAgenda = $agendaManager->findCoursParUtilisateur(1); // ← Changé ici

// $template = $twig->load('login.html.twig');

// echo $template->render(array(
//     "agendas" => $agendas,
//     "cours" => $coursAgenda,
//     'menu' => "agenda"
// ));

require_once 'vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('templates');

$twig = new \Twig\Environment($loader);

echo $twig->render('login.html.twig');

?>