<?php

class ControllerDevoir extends Controller {

    public function __construct(\Twig\Loader\FilesystemLoader $loader, \Twig\Environment $twig)
    {
        parent::__construct($loader, $twig);
    }

    public function creer(): void
    {
        $user = $_SESSION['user'];

        // Sécurité : Rôles autorisés
        if ($user->getRole() !== 'ressource') {
            header('Location: index.php?controleur=connecter&methode=render');
            exit;
        }
        
        // Utilisation du bon DAO (Assurez-vous que le nom de la classe est correct)
        $coursManager = new CoursPrevueDAO($this->getPdo());
        $listeDesCours = $coursManager->findAll(); // Adapté selon vos besoins de filtrage

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idCoursRecu = (int)$_POST['idCour']; 
            $libelleMatiere = "Matière inconnue";
            
            // 1. Recherche du libellé
            foreach ($listeDesCours as $cours) {
                if ($cours->getId() === $idCoursRecu) { 
                    $libelleMatiere = $cours->getLibelle();
                    break;
                }
            }

            // 2. Validation des dates
            $dateHeureDebut = $_POST['date_deb'] . ' ' . $_POST['heure_deb'];
            $dateHeureFin = $_POST['date_fin'] . ' ' . $_POST['heure_fin'];

            if (strtotime($dateHeureFin) <= strtotime($dateHeureDebut)) {
                echo $this->getTwig()->render('creerDevoir.twig', [
                    "lesCours" => $listeDesCours,
                    "error" => "La date de fin doit être postérieure à la date de début."
                ]);
                return;
            }

            $contenuproteger = $_POST['contenu'];

            $nouveauCours = new CoursPrevue(
                null,
                $libelleMatiere,
                $_POST['date_deb'],
                $_POST['date_fin'],
                $_POST['heure_deb'],
                $_POST['heure_fin'],
                $contenuproteger,
                $_POST['Couleur'],
                $idCoursRecu,
                $user->getIdClasse(),
                $user->getId()
            );

            $coursPrevusDAO = new CoursPrevueDAO($this->getPdo());
            if ($coursPrevusDAO->create($nouveauCours)) {
                header('Location: index.php?controleur=coursPrevue&methode=afficher');
                exit();
            }
        }

        echo $this->getTwig()->render('creerCoursPrevue.twig', [
            "titre" => "Créer un cours prévus",
            "lesCours" => $listeDesCours 
        ]);
    }

    public function lister(): void
    {
        $user = $_SESSION['user'];
        if ($user->getRole() !== 'ressource') {
            header('Location: index.php?controleur=connecter&methode=render');
            exit;
        }

        $manager = new CoursPrevueDAO($this->getPdo());
        // On récupère les devoirs créés par l'étudiant (ou sa classe selon votre choix métier)
        $devoirs = $manager->findByEtudiant($user->getId()); 
    
        echo $this->getTwig()->render('listerDevoir.twig', [
            "titre" => "Mes Devoirs",
            "devoirs" => $devoirs 
        ]);
    }
}