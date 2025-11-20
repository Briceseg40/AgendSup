<?php

require_once 'include.php';

// $db = Bd::getInstance();
// $pdo = $db->getConnection();

// $agendaManager = new AgendaDAO($pdo);
// $agendas = $agendaManager->findAll();
// $coursAgenda = $agendaManager->findCoursParUtilisateur(1);

// $template = $twig->load('login.html.twig');

// echo $template->render(array(
//     "agendas" => $agendas,
//     "cours" => $coursAgenda,
//     'menu' => "agenda"
// ));


$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

$action = $_GET['action'] ?? '';

switch ($action) {

    // Page de connexion (page par défaut)
    case 'login':
        echo $twig->render('login.html.twig');
        break;

    // Page "Créer un compte"
    case 'register':
        echo $twig->render('register.html.twig');
        break;

    // Page après connexion réussie
    case 'connected':
        echo $twig->render('connected.html.twig');
        break;
        
    case 'agenda':
        echo $twig->render('agenda.html.twig');
        break;

    case 'join_class':
        echo $twig->render('joinClass.html.twig');
        break;

    case 'forget-Pass':
        echo $twig->render('forgetPasseword.html.twig');
        break;

    case 'create-class':
        echo $twig->render('createClassAndParam.html.twig');
        break;

    // Si l’action n’existe pas → login
    default:
        echo $twig->render('login.html.twig');
        break;
}

?>