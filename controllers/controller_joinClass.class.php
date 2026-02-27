<?php
/* @file controller_joinClass.class.php
 * @brief Contrôleur pour la page de rejoindre une classe.
 * @author Rémi Bouillon
 * @date 20/11/2025
 */
class ControllerJoinClass extends Controller {
    // Constructeur
    /**
     * @brief Constructeur de la classe ControllerJoinClass.
     * @param \Twig\Loader\FilesystemLoader $loader Chargeur de fichiers Twig.
     * @param \Twig\Environment $twig Environnement Twig.
     */
    public function __construct(\Twig\Loader\FilesystemLoader $loader, \Twig\Environment $twig) {
        parent::__construct($loader, $twig);
    }

    /**
     * @brief Rendu de la page de rejoindre une classe.
     */
    public function render() {

        // Vérification session
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?controleur=connecter&methode=connexion');
            exit();
        }
            
        $user = $_SESSION['user'];
        $idEtudiant = is_array($user) ? $user['id'] : $user->getId();
    
        $pdo = Bd::getInstance()->getConnection();
        $classeDAO = new ClasseVirtuelDAO($pdo);
    
        $listeDesClasses = $classeDAO->findInscrites($idEtudiant);
    
        $error = $_SESSION['error_message'] ?? null;
        $success = $_SESSION['success_message'] ?? null;
    
        unset($_SESSION['error_message'], $_SESSION['success_message']);
    
        echo $this->getTwig()->render('joinClass.html.twig', [
            'classes' => $listeDesClasses,
            'error_message' => $error,
            'success_message' => $success
        ]);
    }

    /**
     * @brief Gère les actions sur les classes (rejoindre ou supprimer).
     */
    public function action() {
        /* @brief Vérification de la méthode de la requête. */
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            /* @brief Récupération des données du formulaire. */
            $idClasse = $_POST['id_classe'] ?? null;
            /* @brief Récupération du type d'action (rejoindre ou supprimer). */
            $typeAction = $_POST['action_type'] ?? null;
            /* @brief Vérification de l'ID de la classe. */
            
            $user = $_SESSION['user'];
            $idEtudiant = is_array($user) ? $user['id'] : $user->getId();

            if ($idClasse) {
                $pdo = Bd::getInstance()->getConnection();
                $classeDAO = new ClasseVirtuelDAO($pdo);

                if ($typeAction === 'supprimer') {
                    $classeDAO->delete($idEtudiant, $idClasse); 
                }
                
                if ($typeAction === 'rejoindre') {
                    header('Location: index.php?controleur=classeVirtuel&methode=salle&id=' . $idClasse);
                    exit();
                }
            }
        }
        /* @brief Redirection vers la page de rejoindre une classe. */
        header('Location: index.php?controleur=joinClass&methode=render');
        exit();
    }

    public function rejoindreParCode() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
            $code = trim($_POST['code_classe'] ?? '');
    
            if (!empty($code)) {
    
                $user = $_SESSION['user'];
                $idEtudiant = is_array($user) ? $user['id'] : $user->getId();
    
                $pdo = Bd::getInstance()->getConnection();
                $classeDAO = new ClasseVirtuelDAO($pdo);
                $classe = $classeDAO->findCode($code);
    
                if ($classe) {
    
                    $classeDAO->rejoindre($idEtudiant, $classe->getId());
                    $_SESSION['success_message'] = "Vous avez rejoint la classe avec succés";
    
                } else {
    
                    $_SESSION['error_message'] = "Aucune classe ne correspond à ce code.";
    
                }
            }
        }
    
        header('Location: index.php?controleur=joinClass&methode=render');
        exit();
    }
}