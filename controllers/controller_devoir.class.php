<?php
/* * @file controller_devoir.class.php
 * @brief Contrôleur pour la gestion des devoirs.
 * @version 0.1
 * @date 19/11/2025
 */
class ControllerDevoir extends Controller {

    /**
     * @brief Constructeur de la classe ControllerDevoir.
     * @param \Twig\Loader\FilesystemLoader $loader Chargeur de fichiers Twig.
     * @param \Twig\Environment $twig Environnement Twig.
     */
    public function __construct(\Twig\Loader\FilesystemLoader $loader, \Twig\Environment $twig)
    {
        parent::__construct($loader, $twig);
    }

    /**
     * @brief Affiche les devoirs pour la classe de l'utilisateur connecté.
     * @return void
     */
    public function afficher(): void
    {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?controleur=connecter&methode=connexion');
            exit();
        }

        $user = $_SESSION['user'];
        $manager = new DevoirDAO($this->getPdo());
        $devoirs = $manager->findByClasse($user->getIdClasse()); 

        echo $this->getTwig()->render('AfficherDevoir.twig', [
            'devoirs' => $devoirs,
            'session' => $_SESSION
        ]);
    }

    /**
     * @brief Crée un nouveau devoir.
     * @return void
     */
    public function creer(): void
    {
        /* @brief Récupération de l'utilisateur en session */
        $user = $_SESSION['user'];

        if ($_SESSION['user']->getRole() !== 'délégué') {
            header('Location: index.php?controleur=connecter&methode=render');
            exit;
        }
        elseif ( $_SESSION['user']->getRole() === 'ressource') {
            header('Location: index.php?controleur=connecter&methode=render');
            exit;
        }
        
        /* @brief Récupération des cours correspondant à l'année et au parcours de l'utilisateur */
        $coursManager = new CoursDao($this->getPdo());
        /* @brief Liste des cours filtrés */
        $listeDesCours = $coursManager->findByAnneeEtParcours((int)$user->getAnnee(), $user->getParcour());

        /* @brief Traitement du formulaire lors de la soumission (méthode POST) */
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            /**
             * @brief Récupération de l'ID du cours sélectionné dans le formulaire
             */
            $idCoursRecu = (int)$_POST['idCour']; 
            /**
             * @brief Initialisation de la variable pour le libellé du cours
             */
            $libelleMatiere = "";
            
            foreach ($listeDesCours as $cours) {
                if ($cours->getId() == $idCoursRecu) { 
                    $libelleMatiere = $cours->getLibelle();
                    break;
                }

            /* @brief Vérification de la cohérence des dates et heures */
            // On combine date et heure pour comparer facilement
            $dateHeureDebut = $_POST['date_deb'] . ' ' . $_POST['heure_deb'];
            /* @brief Vérification que la date et l'heure de fin sont postérieures à celles de début */
            $dateHeureFin = $_POST['date_fin'] . ' ' . $_POST['heure_fin'];
            
            /* @brief Si la date de fin est antérieure ou égale à la date de début */

            $contenuproteger = htmlentities($_POST['contenu']);

            if (strtotime($dateHeureFin) <= strtotime($dateHeureDebut)) {
                // En cas d'erreur, on ne sauvegarde pas et on renvoie un message
                $listeDesCours = $coursManager->findByAnneeEtParcours($user->getAnnee(), $user->getParcour());
                echo $this->getTwig()->render('creerDevoir.twig', [
                    "lesCours" => $listeDesCours,
                    "error" => "La date de fin doit être postérieure à la date de début."
                ]);
                return;
            }
            }

            /* @brief Création d'un nouvel objet Devoir avec les données reçues */
            $nouveauDevoir = new Devoir(
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
            /* @brief Initialisation du DAO pour les devoirs */
            $devoirDAO = new DevoirDAO($this->getPdo());
            if ($devoirDAO->create($nouveauDevoir)) {
                header('Location: index.php?controleur=devoir&methode=afficher');
                exit();
            }
        }

        /* @brief Affichage du formulaire de création de devoir (méthode GET ou en cas d'erreur) */
        echo $this->getTwig()->render('creerDevoir.twig', [
            "titre" => "Créer un devoir",
            "lesCours" => $listeDesCours 
        ]);
    }

    /**
     * @brief Modifie un devoir existant.
     * @return void
     */
    public function modifier(): void
{
    $user = $_SESSION['user'];
    $idDevoir = $_GET['id'] ?? null;

    if ($_SESSION['user']->getRole() !== 'délégué') {
        header('Location: index.php?controleur=connecter&methode=render');
        exit;
    }
    elseif ( $_SESSION['user']->getRole() === 'ressource') {
        header('Location: index.php?controleur=connecter&methode=render');
        exit;
    }

    if (!$idDevoir) {
        header("Location: index.php?controleur=devoir&methode=lister");
        exit();
    }

    $devoirManager = new DevoirDAO($this->getPdo());
    $coursManager = new CoursDao($this->getPdo());
    $error = null;

    // Récupération des cours autorisés (même logique que creer)
    $listeDesCours = $coursManager->findByAnneeEtParcours((int)$user->getAnnee(), $user->getParcour());

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $dateHeureDebut = $_POST['date_deb'] . ' ' . $_POST['heure_deb'];
        $dateHeureFin = $_POST['date_fin'] . ' ' . $_POST['heure_fin'];
        $contenuproteger = htmlentities($_POST['contenu']);

        // Récupération de l'ID du cours (sans le s)
        $idCoursRecu = $_POST['idCour'] ?? null; 
        $libelleMatiere = "";

        // On cherche le libellé correspondant à l'ID pour remplir la colonne 'libelle'
        foreach ($listeDesCours as $cours) {
            if ($cours->getId() == $idCoursRecu) { 
                $libelleMatiere = $cours->getLibelle();
                break;
            }
        }

        if (strtotime($dateHeureFin) <= strtotime($dateHeureDebut)) {
            $error = "La date et l'heure de fin doivent être supérieures au début.";
        } else {
            /* * On crée l'objet Devoir. 
             * IMPORTANT : Vérifiez que 'Couleur' a bien une majuscule dans votre HTML
             */
            $devoirModifie = new Devoir(
                (int)$idDevoir,
                $libelleMatiere,
                $_POST['date_deb'],
                $_POST['date_fin'],
                $_POST['heure_deb'],
                $_POST['heure_fin'],
                $contenuproteger,
                $_POST['Couleur'], 
                (int)$idCoursRecu,  
                $user->getIdClasse(),
                $user->getId()
            );

            if ($devoirManager->update($devoirModifie)) {
                header("Location: index.php?controleur=devoir&methode=lister&success=1");
                exit();
            }
        }
    }

    $devoir = $devoirManager->findById((int)$idDevoir);
    
    echo $this->getTwig()->render('modifierDevoir.twig', [
        "titre" => "Modifier le devoir",
        "devoir" => $devoir,
        "cours" => $listeDesCours,
        "error" => $error 
    ]);
}

    /**
     * @brief Supprime un devoir existant.
     *  @return void
     */
    public function supprimer(): void
    {
        if ($_SESSION['user']->getRole() !== 'délégué') {
            header('Location: index.php?controleur=connecter&methode=render');
            exit;
        }
        elseif ( $_SESSION['user']->getRole() === 'ressource') {
            header('Location: index.php?controleur=connecter&methode=render');
            exit;
        }

        /* @brief Récupération de l'ID du devoir à supprimer depuis l'URL */
        $id = $_GET['id'] ?? null;
        /* @brief Si un ID est fourni, procéder à la suppression */
        if ($id) {
            /* @brief Récupération de l'utilisateur en session */
            $manager = new DevoirDAO($this->getPdo());
            /* @brief Suppression du devoir */
            $manager->delete((int)$id);
        }
    
        /* @brief Redirection vers la liste des devoirs après la suppression */ 
        header("Location: index.php?controleur=devoir&methode=lister");
        exit();
    }
    
    /**
     * @brief Liste les devoirs pour l'étudiant connecté.
     * @return void
     */
    public function lister(): void
    {
        /* @brief Si l'utilisateur n'est pas connecté, redirection vers la page de connexion */
        $user = $_SESSION['user'];

        if ($_SESSION['user']->getRole() !== 'délégué') {
            header('Location: index.php?controleur=connecter&methode=render');
            exit;
        }
        elseif ( $_SESSION['user']->getRole() === 'ressource') {
            header('Location: index.php?controleur=connecter&methode=render');
            exit;
        }

        /* @brief Initialisation du gestionnaire de devoirs */
        $manager = new DevoirDAO($this->getPdo());
        
        /* @brief Récupération des devoirs pour la classe de l'étudiant */
        $devoirs = $manager->findByEtudiant($user->getIdClasse()); 
        // Correction : On nomme la variable $devoirs
        $devoirs = $manager->findByEtudiant($user->getId()); 
        
        

    
        /* @brief Affichage de la liste des devoirs */
        echo $this->getTwig()->render('listerDevoir.twig', [
            "titre" => "Mes Devoirs",
            "devoirs" => $devoirs 
        ]);
    }

    /**
     * @brief Fournit les événements de devoirs au format JSON pour l'API.
     *
     * @return void
     */
    public function api_events(): void
    {
        if (ob_get_length()) ob_clean();
        if (!isset($_SESSION['user'])) {
            echo json_encode([]);
            exit;
        }
        /* @brief Récupération de l'utilisateur en session */
        $user = $_SESSION['user'];
        /* @brief Récupération de l'ID de la classe de l'utilisateur */
        $idClasse = $user->getIdClasse(); 
        /* @brief Si l'ID de la classe n'est pas défini, retourner un tableau vide */
        if (!$idClasse) {
            echo json_encode([]);
            exit;
        }
        /* @brief Initialisation du gestionnaire de devoirs */
        $manager = new DevoirDAO($this->getPdo());
        /* @brief Récupération des devoirs pour la classe de l'utilisateur */
        $devoirs = $manager->findByClasse($idClasse); 
        /* @brief Préparation des événements au format attendu par FullCalendar */
        $events = [];
        /* @brief Boucle sur chaque devoir pour formater les données */
        foreach ($devoirs as $d) {
            $events[] = [
                'id'    => $d->getId(),
                'title' => $d->getLibelle(),
                'start' => $d->getDateDeb() . 'T' . $d->getHeureDeb(),
                'end'   => $d->getDatefin() . 'T' . $d->getHeureFin(),
                'extendedProps' => ['description' => $d->getContenu()],
                'color' => $d->getCouleur()
            ];
        }
        /* @brief Envoi de la réponse JSON */
        header('Content-Type: application/json');
        echo json_encode($events);
        exit;
    }    
}