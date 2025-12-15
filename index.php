<?php
session_start();

require_once 'vendor/autoload.php';
require_once 'include.php';

$pdo = Bd::getInstance()->getConnection();

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

$controleurName = $_GET['controleur'] ?? 'connecter';
$methode = $_GET['methode'] ?? 'connexion';

try {
    $controller = ControllerFactory::getController($controleurName, $loader, $twig);

    if (method_exists($controller, $methode)) {
        $controller->$methode();
    } else {
        echo "La méthode $methode n'existe pas dans le contrôleur $controleurName";
    }

} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}

// http://lakartxela.iutbayonne.univ-pau.fr/~bseguret/SAE3.01/C1-C2/AgendSup/