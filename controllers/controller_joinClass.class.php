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
        /* @brief Vérification de la session utilisateur. */
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?controleur=connecter&methode=connexion');
            exit();
        }
        /* @brief Récupération de l'utilisateur connecté. */
        $utilisateurConnecte = $_SESSION['user'];
        /* @brief Récupération de l'ID de l'étudiant. */
        $idEtudiant = is_array($utilisateurConnecte) ? $utilisateurConnecte['id'] : $utilisateurConnecte->getId();
        /* @brief Récupération de la liste des classes de l'étudiant. */
        $pdo = Bd::getInstance()->getConnection();
        /* @brief Initialisation du DAO de classe. */
        $classeDAO = new ClasseDAO($pdo);
        /* @brief Recherche des classes de l'étudiant. */
        $listeDesClasses = $classeDAO->findPerso($idEtudiant);
        /* @brief Rendu du template Twig avec la liste des classes. */
        echo $this->getTwig()->render('joinClass.html.twig', [
            'classes' => $listeDesClasses
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
            if ($idClasse) {
                $pdo = Bd::getInstance()->getConnection();
                $classeDAO = new ClasseDAO($pdo);

                if ($typeAction === 'supprimer') {
                    $classeDAO->delete($idClasse); 
                }
                
                if ($typeAction === 'rejoindre') {
                    header('Location: index.php?controleur=classe&methode=salle&id=' . $idClasse);
                    exit();
                }
            }
        }
        /* @brief Redirection vers la page de rejoindre une classe. */
        header('Location: index.php?controleur=joinClass&methode=render');
        exit();
    }
} 
?>
 