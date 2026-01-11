<?php

class ControllerParamClasse extends Controller
{

    public function __construct(\Twig\Loader\FilesystemLoader $loader, \Twig\Environment $twig)
    {
        parent::__construct($loader, $twig);
    }

    public function render()
    {
        echo $this->getTwig()->render('createClassAndParam.html.twig');
    }

    public function creer()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?controleur=connecter&methode=connexion');
            exit();
        }

        $sessionUser = $_SESSION['user'];
        $utilisateurConnecte = null;

        if (is_array($sessionUser)) {
            $utilisateurConnecte = new Etudiant(
                $sessionUser['id'],
                $sessionUser['nom'],
                $sessionUser['prenom'],
                $sessionUser['role'],
                (int)($sessionUser['annee'] ?? 1),
                $sessionUser['idClasse'] ?? 0,
                $sessionUser['email'],
                '' 
            );
        } else {
            $utilisateurConnecte = $sessionUser;
        }
        $anneeEtudiant = $utilisateurConnecte->getAnnee();
        $idEtudiant = $utilisateurConnecte->getId();
        $idCompose = $utilisateurConnecte->getIdClasse();

        $tdEtudiant = floor(($idCompose % 100) / 10);
        $tpEtudiant = $idCompose % 10;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'] ?? '';
            $code = $_POST['code'] ?? '';
            $nomFichierImage = $_POST['image'] ?? 'agendboyquisait.png';
            $image = 'public/assets/img/' . $nomFichierImage;
            $description = $_POST['description'] ?? '';

            $pdo = Bd::getInstance()->getConnection();
            $classeDAO = new ClasseDAO($pdo);

            if ($classeDAO->findCode($code)) {
                echo $this->getTwig()->render('createClassAndParam.html.twig', ['error' => 'Ce code de classe existe déjà']);
                return;
            }

            $nouvelleClasse = new Classe(
                null,
                $image,
                $nom,
                $description,
                $tdEtudiant,
                $tpEtudiant,
                $idEtudiant,
                $anneeEtudiant,
                $code
            );

            $classeDAO->create($nouvelleClasse);

            header('Location: index.php?controleur=joinClass&methode=render');
            exit();
        }

        $this->render();
    }
}