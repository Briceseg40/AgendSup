<?php
/**
 * @file controller_connecter.php
 * @brief Contrôleur de gestion de la connexion et déconnexion des utilisateurs.
 *
 * Ce contrôleur permet de gérer les actions liées à la connexion et déconnexion des utilisateurs,
 * notamment l'affichage des formulaires de connexion via Twig.
 */
/**
 * @class ControllerConnecter
 * @brief Contrôleur de connexion.
 *
 * Hérite de la classe Controller.
 * Gère les actions liées à la connexion et déconnexion des utilisateurs.
 */
class ControllerConnecter extends Controller {
    /**
     * @brief Constructeur du contrôleur de connexion.
     *
     * @param \Twig\Loader\FilesystemLoader $loader Chargeur de templates Twig.
     * @param \Twig\Environment $twig Environnement Twig.
     */
    public function __construct(\Twig\Loader\FilesystemLoader $loader, \Twig\Environment $twig) {
        parent::__construct($loader, $twig);
    }

    /**
     * @brief Gère la connexion des utilisateurs.
     *
     * Affiche le formulaire de connexion et traite les données soumises.
     * Si les identifiants sont corrects, l'utilisateur est redirigé vers la page connectée.
     * Sinon, un message d'erreur est affiché.
     */
    public function connexion() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['loginName'] ?? '';
            $password = $_POST['password'] ?? '';

            $pdo = Bd::getInstance()->getConnection();
            $etudiantDAO = new EtudiantDAO($pdo);
            $etudiant = $etudiantDAO->findByEmail($email);

            if ($etudiant && $password === $etudiant->getMdp()) {
                $_SESSION['user'] = $etudiant;
                header('Location: index.php?controleur=connecter&methode=render');
                exit();
            } else {
                echo $this->getTwig()->render('login.html.twig', ['error' => 'Identifiants incorrects']);
            }
        } else {
            echo $this->getTwig()->render('login.html.twig');
        }
    }

    /**
     * @brief Gère la déconnexion des utilisateurs.
     *
     * Détruit la session et redirige l'utilisateur vers la page de connexion.
     */
    public function deconnexion() {
        session_destroy();
        header('Location: index.php?controleur=connecter&methode=connexion');
        exit();
    }
    
    /**
     * @brief Affiche la page connectée.
     *
     * Vérifie si l'utilisateur est connecté.
     * Si oui, affiche la page connectée avec les informations de l'utilisateur.
     * Sinon, redirige vers la page de connexion.
     */
    public function render() {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?controleur=connecter&methode=connexion');
            exit();
        }
        echo $this->getTwig()->render('connected.html.twig', ['user' => $_SESSION['user']]);
    }

    
}