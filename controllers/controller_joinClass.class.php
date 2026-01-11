<?php

class ControllerJoinClass extends Controller {

    public function __construct(\Twig\Loader\FilesystemLoader $loader, \Twig\Environment $twig) {
        parent::__construct($loader, $twig);
    }

    public function render() {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?controleur=connecter&methode=connexion');
            exit();
        }
        $utilisateurConnecte = $_SESSION['user'];

        $idEtudiant = is_array($utilisateurConnecte) ? $utilisateurConnecte['id'] : $utilisateurConnecte->getId();

        $pdo = Bd::getInstance()->getConnection();
        $classeDAO = new ClasseDAO($pdo);
        $listeDesClasses = $classeDAO->findPerso($idEtudiant);

        echo $this->getTwig()->render('joinClass.html.twig', [
            'classes' => $listeDesClasses
        ]);
    }

    public function action() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $idClasse = $_POST['id_classe'] ?? null;
            $typeAction = $_POST['action_type'] ?? null;

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

        header('Location: index.php?controleur=joinClass&methode=render');
        exit();
    }
} 
?>
 