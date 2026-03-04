<?php

class controllerCoursPrevue extends Controller {

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
        
        // On utilise bien le CoursDAO pour la liste déroulante des matières
        $coursManager = new CoursDAO($this->getPdo());
        $listeDesCours = $coursManager->findAll(); 

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idCoursRecu = (int)$_POST['idCour']; 
            $libelleMatiere = "Matière inconnue";
            
            foreach ($listeDesCours as $cours) {
                // Utilisation de == car l'ID peut arriver en string depuis le formulaire
                if ($cours->getId() == $idCoursRecu) { 
                    $libelleMatiere = $cours->getLibelle();
                    break;
                }
            }

            // Vérification chronologique
            $dateHeureDebut = $_POST['date_deb'] . ' ' . $_POST['heure_deb'];
            $dateHeureFin = $_POST['date_fin'] . ' ' . $_POST['heure_fin'];

            if (strtotime($dateHeureFin) <= strtotime($dateHeureDebut)) {
                echo $this->getTwig()->render('creerCoursPrevus.twig', [
                    "lesCours" => $listeDesCours,
                    "error" => "La date de fin doit être postérieure à la date de début."
                ]);
                return;
            }

            // --- CORRECTION DE L'ORDRE DES PARAMÈTRES (11 au total) ---
            $nouveauCours = new CoursPrevue(
                null,                // 1. $id
                $_POST['date_deb'],  // 2. $date_deb
                $_POST['date_fin'],  // 3. $date_fin
                $_POST['heure_deb'], // 4. $heure_deb
                $_POST['heure_fin'], // 5. $heure_fin
                $libelleMatiere,     // 6. $libelle
                $_POST['contenu'],   // 7. $description
                $_POST['Couleur'],   // 8. $couleur
                $user->getId(),      // 9. $idEtudiant (L'ID qui posait l'erreur SQL)
                null,                // 10. $idClasseVirtuel
                $idCoursRecu         // 11. $idCours
            );

            $coursPrevusDAO = new CoursPrevueDAO($this->getPdo());
            
            if ($coursPrevusDAO->create($nouveauCours)) {
                // Redirection vers l'affichage global ou la liste
                header('Location: index.php?controleur=devoir&methode=afficher');
                exit();
            } else {
                $errorServer = "Erreur lors de l'enregistrement en base de données.";
            }
        }

            echo $this->getTwig()->render('creerCoursPrevus.twig', [
                "titre" => "Créer un cours prévu",
                "lesCours" => $listeDesCours,
                "error" => $errorServer ?? null
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
        $cours = $manager->findByEtudiant($user->getId()); 
    
        echo $this->getTwig()->render('listerCoursPrevus.twig', [
            "titre" => "Mes Cours Prévu",
            "cours" => $cours 
        ]);
    }

    public function modifier(): void
        {
            $user = $_SESSION['user'];
            $idCoursPrevue = $_GET['id'] ?? null;

            // 1. Sécurité : Vérification du rôle 'ressource'
            if ($user->getRole() !== 'ressource') {
                header('Location: index.php?controleur=connecter&methode=render');
                exit;
            }

            $coursPrevueDAO = new CoursPrevueDAO($this->getPdo());
            $coursDAO = new CoursDAO($this->getPdo()); // Pour la liste des matières
            $error = null;

            // Récupération de toutes les matières disponibles pour le select
            $listeDesCours = $coursDAO->findByAnneeEtParcours($user->getAnnee(), $user->getParcour()); 

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $dateHeureDebut = $_POST['date_deb'] . ' ' . $_POST['heure_deb'];
                $dateHeureFin = $_POST['date_fin'] . ' ' . $_POST['heure_fin'];
                
                $idCoursRecu = $_POST['idCour'] ?? null; 
                $libelleMatiere = "Matière inconnue";

                // Recherche du libellé correspondant
                foreach ($listeDesCours as $c) {
                    if ($c->getId() == $idCoursRecu) { 
                        $libelleMatiere = $c->getLibelle();
                        break;
                    }
                }

                if (strtotime($dateHeureFin) <= strtotime($dateHeureDebut)) {
                    $error = "La date et l'heure de fin doivent être supérieures au début.";
                } else {
                    /* * 2. Création de l'objet CoursPrevue 
                    * ATTENTION : L'ordre des paramètres doit correspondre au fichier coursPrevue.class.php
                    */
                    $coursModifie = new CoursPrevue(
                        (int)$idCoursPrevue, // 1. id
                        $_POST['date_deb'],   // 2. date_deb
                        $_POST['date_fin'],   // 3. date_fin
                        $_POST['heure_deb'],  // 4. heure_deb
                        $_POST['heure_fin'],  // 5. heure_fin
                        $libelleMatiere,      // 6. libelle
                        $_POST['contenu'],    // 7. description
                        $_POST['Couleur'],    // 8. couleur
                        $user->getId(),       // 9. idEtudiant
                        null,                 // 10. idClasseVirtuel
                        (int)$idCoursRecu     // 11. idCours
                    );

                    if ($coursPrevueDAO->update($coursModifie)) {
                        header("Location: index.php?controleur=coursPrevue&methode=lister");
                        exit();
                    } else {
                        $error = "Erreur lors de la mise à jour en base de données.";
                    }
                }
            }

            // Récupération des données actuelles pour pré-remplir le formulaire
            
            $coursPrevue = $coursPrevueDAO->findById((int)$idCoursPrevue);

        echo $this->getTwig()->render('modifierCoursPrevus.twig', [
            "titre"       => "Modifier le cours prévu",
            "coursPrevue" => $coursPrevue,
            "cours"       => $listeDesCours,
            "error"       => $error 
        ]);
    }


    public function supprimer(): void
    {
        if ($_SESSION['user']->getRole() !== 'ressource') {
            header('Location: index.php?controleur=connecter&methode=render');
            exit;
        }

        /* @brief Récupération de l'ID du devoir à supprimer depuis l'URL */
        $id = $_GET['id'] ?? null;
        /* @brief Si un ID est fourni, procéder à la suppression */
        if ($id) {
            /* @brief Récupération de l'utilisateur en session */
            $manager = new CoursPrevueDAO($this->getPdo());
            /* @brief Suppression du devoir */
            $manager->delete((int)$id);
        }
    
        /* @brief Redirection vers la liste des devoirs après la suppression */ 
        header("Location: index.php?controleur=coursPrevue&methode=lister");
        exit();
    }

}