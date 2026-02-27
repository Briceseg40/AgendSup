<?php
/**
 * @file controller_connecter.php
 * @brief Contrôleur pour la gestion de la connexion et déconnexion des utilisateurs.
 * @date 19/11/2025
 */
class ControllerConnecter extends Controller {
    // Constructeur
    /**
     * @brief Constructeur de la classe ControllerConnecter.
     * @param \Twig\Loader\FilesystemLoader $loader Chargeur de fichiers Twig.
     * @param \Twig\Environment $twig Environnement Twig.
     */
    public function __construct(\Twig\Loader\FilesystemLoader $loader, \Twig\Environment $twig) {
        parent::__construct($loader, $twig);
    }
    // Méthodes
    /**
     * @brief Gère la connexion des utilisateurs.
     */
    public function connexion() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
            $email = $_POST['loginName'] ?? '';
            $password = $_POST['password'] ?? '';
    
            $etudiantDAO = new EtudiantDAO($this->getPdo());
            $etudiant = $etudiantDAO->findByEmail($email);
    
            if ($etudiant && password_verify($password, $etudiant->getMdp())) {
    
                $_SESSION['authentifie'] = true;
                $_SESSION['user'] = $etudiant;
                $_SESSION['role'] = $etudiant->getRole();
    
                if ($etudiant->getRole() === 'admin') {
                    header('Location: ?controleur=admin&methode=dashboard');
                    exit();
                }
    
                header('Location: index.php?controleur=connecter&methode=render');
                exit();
    
            } else {
                echo $this->getTwig()->render('login.html.twig', [
                    'erreur' => 'Email ou mot de passe incorrect.'
                ]);
            }
    
        } else {
            echo $this->getTwig()->render('login.html.twig');
        }
    }
    
    /**
     * @brief Gère la déconnexion des utilisateurs.
     */
    public function deconnexion() {
        session_destroy(); //
        header('Location: index.php?controleur=connecter&methode=connexion');
        exit();
    }

    /**
     * @brief Rend la page pour les utilisateurs connectés.
     */
    public function render() {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?controleur=connecter&methode=connexion');
            exit();
        }

        echo $this->getTwig()->render('connected.html.twig', [
            'user' => $_SESSION['user']
        ]);
    }
}