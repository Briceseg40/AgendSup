<?php
class ControllerDevoir extends Controller{

    public function __construct(\Twig\Loader\FilesystemLoader $loader, \Twig\Environment $twig)
    {
        parent::__construct($loader, $twig);
    }

    //Afficher
    public function afficher(): void
    {
        $manager = new DevoirDAO($this->getPdo());
        $devoir = $manager->findAll();
        //var_dump($devoir);
        $template = $this->getTwig()->load('devoir/afficher.twig');

        echo $template->render([
            'categories' => $devoir,
            'menu' => "category" 
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
    
        $manager = new DevoirDAO($this->getPdo());
        $devoirs = $manager->findAll();
    
        $events = [];
    
        foreach ($devoirs as $d) {
            $dateDeb = $d->getDateDeb();
            if (!$dateDeb || $dateDeb === '0000-00-00') {
                continue; // MVC propre : on ignore les données invalides
            }
    
            $events[] = [
                'id'    => $d->getId(),
                'title' => $d->getLibelle(),
                'start' => $d->getDateDeb() . 'T' . $d->getHeureDeb() . ':00',
                'end'   => $d->getDatefin() . 'T' . $d->getHeureFin() . ':00',
                'description' => $d->getContenu(),
                'color' => $d->getCouleur()
            ];
            
        }
    
        header('Content-Type: application/json');
        echo json_encode($events);
        exit;
    }
    
}
