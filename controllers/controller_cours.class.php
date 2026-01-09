<?php
/**
 * @file controller_cours.class.php
 * @brief Contrôleur de gestion des cours.
 *
 * Ce contrôleur permet de gérer les actions liées aux cours,
 * notamment l'affichage de la liste des cours via Twig.
 */
class controllerCours extends Controller
{
    /**
     * @brief Constructeur du contrôleur des cours.
     *
     * @param \Twig\Loader\FilesystemLoader $loader Chargeur de templates Twig.
     * @param \Twig\Environment $twig Environnement Twig.
     */
    public function __construct(\Twig\Loader\FilesystemLoader $loader, \Twig\Environment $twig)
    {
        parent::__construct($loader, $twig);
    }

    /**
     * @brief Affiche la liste des cours.
     *
     * Récupère toutes les cours via le DAO et les affiche
     * en utilisant un template Twig.
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
     * @brief Affiche la liste des cours d'un agenda spécifique.
     *
     * Récupère les cours associés à un agenda via le DAO et les affiche
     * en utilisant un template Twig.
     *
     * @param int $id_Agenda Identifiant de l'agenda.
     */
    public function listerByAgenda($id_Agenda): void
    {
        $manager = new CoursDao($this->getPdo());
        $cours = $manager->findByAgenda($id_Agenda);

        //Chargement du template
        $template = $this->getTwig()->load('cours.twig');

        //Affichage du template et transmission des données
        echo $template->render(array(
            'cours' => $cours,
            'menu' => "category"
        ));
    }

        //Créer
    /*  * @brief Affiche le formulaire de création d'un cours.
     */
     public function creer(): void
     {
         $template = $this->getTwig()->load('cours/creer.twig');
 
         echo $template->render([
             "titre" => "Créer un cours"
         ]);
     }
 
     //Modifier
     /*  * @brief Affiche le formulaire de modification d'un cours.
     */
     public function modifier(): void
     {
         $template = $this->getTwig()->load('cours/modifier.twig');
 
         echo $template->render([
             "titre" => "Modifier un cours"
         ]);
     }
 
     //Supprimer
     /*  * @brief Affiche le formulaire de suppression d'un cours.
     */
     public function supprimer(): void
     {
         $template = $this->getTwig()->load('cours/supprimer.twig');
 
         echo $template->render([
             "titre" => "Supprimer un cours"
         ]);
     }
}
