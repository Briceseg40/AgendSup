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
        
        $user = $_SESSION['user'];
        $idEtudiant = is_array($user) ? $user['id'] : $user->getId();

        $pdo = Bd::getInstance()->getConnection();
        $classeDAO = new ClasseDAO($pdo);
        
        $listeDesClasses = $classeDAO->findInscrites($idEtudiant);

        echo $this->getTwig()->render('joinClass.html.twig', [
            'classes' => $listeDesClasses
        ]);
    }

    public function action() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $idClasse = $_POST['id_classe'] ?? null;
            $typeAction = $_POST['action_type'] ?? null;
            
            $user = $_SESSION['user'];
            $idEtudiant = is_array($user) ? $user['id'] : $user->getId();

            if ($idClasse) {
                $pdo = Bd::getInstance()->getConnection();
                $classeDAO = new ClasseDAO($pdo);

                if ($typeAction === 'supprimer') {
                    $classeDAO->delete($idEtudiant, $idClasse); 
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

    public function rejoindreParCode() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $code = $_POST['code_classe'] ?? '';

            if (!empty($code)) {
                $user = $_SESSION['user'];
                $idEtudiant = is_array($user) ? $user['id'] : $user->getId();

                $pdo = Bd::getInstance()->getConnection();
                $classeDAO = new ClasseDAO($pdo);
                $classe = $classeDAO->findCode($code);

                if ($classe) {
                    $classeDAO->rejoindre($idEtudiant, $classe->getId());
                }
            }
        }
        header('Location: index.php?controleur=joinClass&methode=render');
        exit();
    }
}