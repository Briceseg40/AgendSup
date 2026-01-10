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
        $message = null;

        $coursManager = new CoursDao($this->getPdo());
        $listeDesCours = $coursManager->findByAnneeEtParcours((int)$user->getAnnee(), $user->getParcour());

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Le front envoie l'ID dans le champ nommé "libelle" 
            // car ton Twig dit <select name="libelle"> et <option value="{{ cours.id }}">
            $idCoursRecu = (int)$_POST['libelle']; 
            
            $libelleMatiere = "";
            // On cherche le NOM correspondant à cet ID pour ton objet Devoir
            foreach ($listeDesCours as $cours) {
                if ((int)$cours['id'] === $idCoursRecu) {
                    $libelleMatiere = $cours['libelle'];
                    break;
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
        $template = $this->getTwig()->load('modifierDevoir.twig');
        echo $template->render(["titre" => "Modifier un devoir"]);
    }

    // Supprimer
    public function supprimer(): void
    {
        $template = $this->getTwig()->load('supprimerDevoir.twig');
        echo $template->render(["titre" => "Supprimer un devoir"]);
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