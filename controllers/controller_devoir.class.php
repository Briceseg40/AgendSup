<?php
class ControllerDevoir extends Controller{

    public function __construct(\Twig\Loader\FilesystemLoader $loader, \Twig\Environment $twig)
    {
        parent::__construct($loader, $twig);
    }

    //Afficher
    public function afficher(): void
{
    if (!isset($_SESSION['user'])) {
        header('Location: index.php?controleur=connecter&methode=connexion');
        exit();
    }

    $user = $_SESSION['user'];
    $manager = new DevoirDAO($this->getPdo());
    
    // On passe l'ID de la classe de l'utilisateur connecté
    $devoirs = $manager->findByClasse($user->getIdClasse()); 

    echo $this->getTwig()->render('AfficherDevoir.twig', [
        'devoirs' => $devoirs,
        'session' => $_SESSION
    ]);
}

    //Creer
    public function creer(): void
{
    // 1. On récupère l'utilisateur en session
    $user = $_SESSION['user'];
    $message = null;

    // --- AJOUT : Récupération des cours pour le formulaire ---
    $annee = $user->getAnnee(); // On récupère l'année de l'étudiant
    $parcours = $user->getParcour(); // On récupère son parcours (A, D ou null)
    
    $coursManager = new CoursDao($this->getPdo());
    $listeDesCours = $coursManager->findByAnneeEtParcours((int)$annee, $parcours);
    // ---------------------------------------------------------

    // 2. Si le formulaire est soumis (méthode POST)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        // Création de l'objet Devoir
        $nouveauDevoir = new Devoir(
            null,
            $_POST['libelle'],
            $_POST['date_deb'],
            $_POST['date_fin'],
            $_POST['heure_deb'],
            $_POST['heure_fin'],
            $_POST['contenu'],
            $_POST['Couleur'],
            $_POST['idCours'], // MODIFIÉ : On utilise l'ID récupéré du select Twig
            $user->getIdClasse()
        );

        $devoirDAO = new DevoirDAO($this->getPdo());
        
        if ($devoirDAO->create($nouveauDevoir)) {
            header('Location: index.php?controleur=devoir&methode=afficher');
            exit();
        } else {
            $message = "Erreur lors de la création du devoir.";
        }
    }

    // 3. Affichage du formulaire avec transmission de 'lesCours'
    echo $this->getTwig()->render('creerDevoir.twig', [
        "titre" => "Créer un devoir",
        "erreur" => $message,
        "lesCours" => $listeDesCours // On envoie la liste à Twig
    ]);
}

    public function creer1(): void
    {
        // 1. On récupère l'utilisateur en session pour avoir son idClasse
        $user = $_SESSION['user'];
        $message = null;

        // 2. Si le formulaire est soumis (méthode POST)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // Création de l'objet Devoir avec les données du formulaire et l'idClasse de l'utilisateur
            $nouveauDevoir = new Devoir(
                null,                  // ID null car auto-incrémenté en BDD
                $_POST['libelle'],
                $_POST['date_deb'],
                $_POST['date_fin'],
                $_POST['heure_deb'],
                $_POST['heure_fin'],
                $_POST['contenu'],
                $_POST['Couleur'],     // Correspond au name="Couleur" dans Twig
                1,                     // idCours par défaut (à adapter si vous gérez les IDs de cours)
                $user->getIdClasse()   // On utilise l'ID de classe de l'étudiant connecté
            );

            // Appel au DAO pour l'insertion
            $devoirDAO = new DevoirDAO($this->getPdo());
            
            if ($devoirDAO->create($nouveauDevoir)) {
                // Redirection après succès pour éviter de renvoyer le formulaire en rafraîchissant
                header('Location: index.php?controleur=devoir&methode=afficher');
                exit();
            } else {
                $message = "Erreur lors de la création du devoir.";
            }
        }

        // 3. Affichage du formulaire (que ce soit le premier chargement ou après une erreur)
        echo $this->getTwig()->render('creerDevoir.twig', [
            "titre" => "Créer un devoir",
            "erreur" => $message
        ]);
    }


    //Modifier
    public function modifier(): void
    {
        $template = $this->getTwig()->load('modifierDevoir.twig');

        echo $template->render([
            "titre" => "Modifier un devoir"
        ]);
    }

    //Supprimer
    public function supprimer(): void
    {
        $template = $this->getTwig()->load('supprimerDevoir.twig');
        
        echo $template->render([
                "titre" => "Supprimer un devoir"
        ]);
    }

    // Route API pour FullCalendar
    public function api_events(): void
    {
        if (ob_get_length()) ob_clean();
    
        // 1. Vérification de la session
        if (!isset($_SESSION['user'])) {
            echo json_encode([]);
            exit;
        }
    
        $user = $_SESSION['user'];
        
        // 2. Récupération sécurisée de l'ID de classe
        // On utilise l'ID de l'étudiant connecté pour filtrer les devoirs
        $idClasse = $user->getIdClasse(); 
    
        if (!$idClasse) {
            echo json_encode([]);
            exit;
        }
    
        $manager = new DevoirDAO($this->getPdo());
        
        // 3. Passage du paramètre au DAO
        $devoirs = $manager->findByClasse($idClasse); 
    
        $events = [];
        foreach ($devoirs as $d) {
            $events[] = [
                'id'    => $d->getId(),
                'title' => $d->getLibelle(),
                'start' => $d->getDateDeb() . 'T' . $d->getHeureDeb(),
                'end'   => $d->getDatefin() . 'T' . $d->getHeureFin(),
                'extendedProps' => [
                'description' => $d->getContenu()
                ],
                'color' => $d->getCouleur()
            ];
        }
    
        header('Content-Type: application/json');
        echo json_encode($events);
        exit;
    }    
}
