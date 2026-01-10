<?php


class controllerCours extends Controller
{
    public function __construct(\Twig\Loader\FilesystemLoader $loader, \Twig\Environment $twig)
    {
        parent::__construct($loader, $twig);
    }

    public function lister(): void
    {
        $manager = new CoursDao($this->getPdo());
        $cours = $manager->findAll();

        //Chargement du template
        $template = $this->getTwig()->load('cours.twig');

        //Affichage du template et transmission des données
        echo $template->render(array(
            'categories' => $cours,
        ));
    }

    public function findByAnnee($Annee): void
{
    // 1. Récupérer le parcours de l'utilisateur (depuis la session ou l'objet User)
    // On suppose que l'info est stockée en session comme dans votre Twig initial
    $parcours = $_SESSION['user']['Parcour'] ?? null; 

    // 2. Appeler le manager avec les deux critères
    $manager = new CoursDao($this->getPdo());
    $listeDesCours = $manager->findByAnneeEtParcours((int)$Annee, $parcours);

    // 3. Chargement du template
    $template = $this->getTwig()->load('cours.twig');

    // 4. Affichage et transmission
    echo $template->render(array(
        'lesCours' => $listeDesCours, // On utilise un nom explicite
        'menu' => "category"
    ));
}

     //Creer
     public function creer(): void
     {
         $template = $this->getTwig()->load('cours/creer.twig');
 
         echo $template->render([
             "titre" => "Créer un cours"
         ]);
     }
 
     //Modifier
     public function modifier(): void
     {
         $template = $this->getTwig()->load('cours/modifier.twig');
 
         echo $template->render([
             "titre" => "Modifier un cours"
         ]);
     }
 
     //Supprimer
     public function supprimer(): void
     {
         $template = $this->getTwig()->load('cours/supprimer.twig');
 
         echo $template->render([
             "titre" => "Supprimer un cours"
         ]);
     }
}
