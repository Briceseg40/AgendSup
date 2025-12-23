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

    echo $this->getTwig()->render('devoir/Afficher.twig', [
        'devoirs' => $devoirs,
        'session' => $_SESSION
    ]);
}

    //Lister
    public function lister(): void
    {
        $template = $this->getTwig()->load('devoir/lister.twig');

        echo $template->render([
            "titre" => "Liste des devoirs"
        ]);
    }

    //Creer
    public function creer(): void
    {
        $template = $this->getTwig()->load('devoir/creer.twig');

        echo $template->render([
            "titre" => "Créer un devoir"
        ]);
    }

    //Modifier
    public function modifier(): void
    {
        $template = $this->getTwig()->load('devoir/modifier.twig');

        echo $template->render([
            "titre" => "Modifier un devoir"
        ]);
    }

    //Supprimer
    public function supprimer(): void
    {
        $template = $this->getTwig()->load('devoir/supprimer.twig');
        
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
