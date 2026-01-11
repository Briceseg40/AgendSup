<?php
class ControllerDevoir extends Controller {

    public function __construct(\Twig\Loader\FilesystemLoader $loader, \Twig\Environment $twig)
    {
        parent::__construct($loader, $twig);
    }

    // Afficher
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

    // Creer
    public function creer(): void
    {
        $user = $_SESSION['user'];

        $coursManager = new CoursDao($this->getPdo());
        $listeDesCours = $coursManager->findByAnneeEtParcours((int)$user->getAnnee(), $user->getParcour());

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Le front envoie l'ID dans le champ nommé "libelle" 
            // car ton Twig dit <select name="libelle"> et <option value="{{ cours.id }}">
            $idCoursRecu = (int)$_POST['libelle']; 
            
            $libelleMatiere = "";
            // On cherche le NOM correspondant à cet ID pour ton objet Devoir
            // On utilise les méthodes de l'objet Cours
            foreach ($listeDesCours as $cours) {
                if ((int)$cours->getId() === $idCoursRecu) { 
                    $libelleMatiere = $cours->getLibelle();
                    break;
                }

                // On combine date et heure pour comparer facilement
            $dateHeureDebut = $_POST['date_deb'] . ' ' . $_POST['heure_deb'];
            $dateHeureFin = $_POST['date_fin'] . ' ' . $_POST['heure_fin'];

            if (strtotime($dateHeureFin) <= strtotime($dateHeureDebut)) {
                // En cas d'erreur, on ne sauvegarde pas et on renvoie un message
                $listeDesCours = $coursManager->findByAnneeEtParcours((int)$user->getAnnee(), $user->getParcour());
                echo $this->getTwig()->render('creerDevoir.twig', [
                    "lesCours" => $listeDesCours,
                    "error" => "La date de fin doit être postérieure à la date de début."
                ]);
                return;
            }
            }

            // Maintenant $idCoursRecu vaut 85 et $libelleMatiere vaut le nom du cours
            $nouveauDevoir = new Devoir(
                null,
                $libelleMatiere,
                $_POST['date_deb'],
                $_POST['date_fin'],
                $_POST['heure_deb'],
                $_POST['heure_fin'],
                $_POST['contenu'],
                $_POST['Couleur'],
                $idCoursRecu,     // Ce n'est plus NULL, c'est l'entier 85
                $user->getIdClasse(),
                $user->getId()  // On assigne l'ID de l'étudiant connecté
            );

            $devoirDAO = new DevoirDAO($this->getPdo());
            if ($devoirDAO->create($nouveauDevoir)) {
                header('Location: index.php?controleur=devoir&methode=afficher');
                exit();
            }
        }

        // BIEN VERIFIER QUE CETTE ACCOLADE FERME LE "IF POST"
        echo $this->getTwig()->render('creerDevoir.twig', [
            "titre" => "Créer un devoir",
            "lesCours" => $listeDesCours 
        ]);
    }

    // Modifier
    public function modifier(): void
    {
        $user = $_SESSION['user'];
        $idDevoir = $_GET['id'] ?? null;
    
        if (!$idDevoir) {
            header("Location: index.php?controleur=devoir&methode=lister");
            exit();
        }
    
        $devoirManager = new DevoirDAO($this->getPdo());
        $coursManager = new CoursDao($this->getPdo());
        $error = null; // Variable pour stocker le message d'erreur
    
        // 1. TRAITEMENT DU FORMULAIRE (SI POST)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // --- NOUVEAU : VÉRIFICATION DE LA CHRONOLOGIE ---
            $dateHeureDebut = $_POST['date_deb'] . ' ' . $_POST['heure_deb'];
            $dateHeureFin = $_POST['date_fin'] . ' ' . $_POST['heure_fin'];
    
            if (strtotime($dateHeureFin) <= strtotime($dateHeureDebut)) {
                $error = "La date et l'heure de fin doivent être supérieures au début.";
            } else {
                // Si c'est correct, on procède à la modification
                $devoirModifie = new Devoir(
                    (int)$idDevoir,
                    $_POST['libelle'] ?? '', // Assurez-vous que ce champ existe dans votre HTML
                    $_POST['date_deb'],
                    $_POST['date_fin'],
                    $_POST['heure_deb'],
                    $_POST['heure_fin'],
                    $_POST['contenu'],
                    $_POST['Couleur'],
                    (int)$_POST['idCours'],
                    (int)$user->getIdClasse(),
                    (int)$user->getId()
                );
    
                if ($devoirManager->update($devoirModifie)) {
                    header("Location: index.php?controleur=devoir&methode=lister&success=1");
                    exit();
                }
            }
        }
    
        // 2. AFFICHAGE DU FORMULAIRE (GET ou Retour d'erreur)
        $devoir = $devoirManager->findById((int)$idDevoir);
        $listeDesCours = $coursManager->findAll();
    
        echo $this->getTwig()->render('modifierDevoir.twig', [
            "titre" => "Modifier le devoir",
            "devoir" => $devoir,
            "cours" => $listeDesCours,
            "error" => $error // On envoie l'erreur au template
        ]);
    }

    
    // Supprimer
    public function supprimer(): void
    {
        // 1. Récupération de l'ID depuis l'URL (index.php?controleur=devoir&methode=supprimer&id=...)
        $id = $_GET['id'] ?? null;
    
        if ($id) {
            // 2. Initialisation du DAO
            $manager = new DevoirDAO($this->getPdo());
            
            // 3. Appel de la méthode de suppression (à créer dans le DAO ci-dessous)
            $manager->delete((int)$id);
            
            // Optionnel : Ajouter un message flash ici pour confirmer la suppression
        }
    
        // 4. Redirection vers la liste pour voir le résultat immédiatement
        header("Location: index.php?controleur=devoir&methode=lister");
        exit();
    }
    
    public function lister(): void
    {
        // Récupération de l'utilisateur en session
        $user = $_SESSION['user'];
        
        // Initialisation du DAO
        $manager = new DevoirDAO($this->getPdo());
        
        // Correction : On nomme la variable $devoirs
        $devoirs = $manager->findByEtudiant($user->getIdClasse()); 
    
        // On envoie 'devoirs' au template pour correspondre au {% for devoir in devoirs %}
        echo $this->getTwig()->render('listerDevoir.twig', [
            "titre" => "Mes Devoirs",
            "devoirs" => $devoirs 
        ]);
    }

    // Route API pour FullCalendar
    public function api_events(): void
    {
        if (ob_get_length()) ob_clean();
        if (!isset($_SESSION['user'])) {
            echo json_encode([]);
            exit;
        }

        $user = $_SESSION['user'];
        $idClasse = $user->getIdClasse(); 
        if (!$idClasse) {
            echo json_encode([]);
            exit;
        }

        $manager = new DevoirDAO($this->getPdo());
        $devoirs = $manager->findByClasse($idClasse); 

        $events = [];
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

        header('Content-Type: application/json');
        echo json_encode($events);
        exit;
    }    
}