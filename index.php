<?php
/* @brief index.php
 * @brief Point d'entrée principal de l'application.
 * @date 19/06/2024
 */
require_once 'modeles/etudiant.class.php';
require_once 'modeles/etudiant.class.php'; 
require_once 'modeles/etudiant.dao.php';

session_start();

require_once 'vendor/autoload.php';
require_once 'include.php'; 
/* @brief Initialisation de la connexion à la base de données.*/
$pdo = Bd::getInstance()->getConnection();
/* @brief Initialisation du chargeur de classes.*/
$controleurName = $_GET['controleur'] ?? 'connecter';
/* @brief Initialisation de la méthode à appeler dans le contrôleur.*/
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