<?php

require_once 'include.php';

$db = Bd::getInstance();
$pdo = $db->getConnection();

$agendaManager = new AgendaDAO($pdo);
$agendas = $agendaManager->findAll();
$coursAgenda = $agendaManager->findCoursParUtilisateur(1); // ← Changé ici

$template = $twig->load('index.twig');

echo $template->render(array(
    "agendas" => $agendas,
    "cours" => $coursAgenda,
    'menu' => "agenda"
));

?>