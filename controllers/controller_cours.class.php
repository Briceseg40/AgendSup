<?php
/* @file controller_cours.class.php
 * @author Rémi Bouillon et Brice Seguret
 * @brief Contrôleur pour la gestion des cours.
 * @details Ce contrôleur gère les actions liées aux cours,
 * telles que la liste, la création, la modification et la suppression.
 * @version 0.1
 * @date 19/11/2025
 */
class controllerCours extends Controller
{
    // Constructeur
    /**
     * @brief Constructeur de la classe controllerCours.
     * @param \Twig\Loader\FilesystemLoader $loader Chargeur de fichiers Twig.
     * @param \Twig\Environment $twig Environnement Twig.
     */
    public function __construct(\Twig\Loader\FilesystemLoader $loader, \Twig\Environment $twig)
    {
        parent::__construct($loader, $twig);
    }

    /**
     * @brief Liste tous les cours.
     */
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

    /**
     * @brief Liste les cours filtrés par année et parcours de l'utilisateur.
     * @param int $Annee Année pour filtrer les cours.
     */
    public function findByAnnee($Annee): void{
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

    /**
     * @brief Crée un nouveau cours.
     *
     * @return void
     */
     public function creer(): void
     {
         $template = $this->getTwig()->load('cours/creer.twig');
 
         echo $template->render([
             "titre" => "Créer un cours"
         ]);
     }
 
     //Modifier
     /**
      * @brief Modifie un cours existant.
      *
      * @return void
      */
     public function modifier(): void
     {
         $template = $this->getTwig()->load('cours/modifier.twig');
 
         echo $template->render([
             "titre" => "Modifier un cours"
         ]);
     }
 
     //Supprimer
     /**
      * @brief Supprime un cours existant.
      *
      * @return void
      */
     public function supprimer(): void
     {
         $template = $this->getTwig()->load('cours/supprimer.twig');
 
         echo $template->render([
             "titre" => "Supprimer un cours"
         ]);
     }
}
