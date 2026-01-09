<?php
/**
 * @file controller_devoir.class.php
 * @brief Contrôleur de gestion des devoirs.
 *
 * Ce contrôleur permet de gérer les actions liées aux devoirs,
 * notamment l'affichage, la création, la modification et la suppression des devoirs via Twig.
 */
class ControllerDevoir extends Controller{
    //Constructeur
    /**
     * @brief Constructeur du contrôleur des devoirs.
     *
     * @param \Twig\Loader\FilesystemLoader $loader Chargeur de templates Twig.
     * @param \Twig\Environment $twig Environnement Twig.
     */
    public function __construct(\Twig\Loader\FilesystemLoader $loader, \Twig\Environment $twig)
    {
        parent::__construct($loader, $twig);
    }

    //Afficher
    /**
     * @brief Affiche la liste des devoirs.
     *
     * Récupère toutes les devoirs via le DAO et les affiche
     * en utilisant un template Twig.
     */
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
    /**
     * @brief Affiche la liste des devoirs.
     *
     * Récupère toutes les devoirs via le DAO et les affiche
     * en utilisant un template Twig.
     */
    public function lister(): void
    {
        $template = $this->getTwig()->load('devoir/lister.twig');

        echo $template->render([
            "titre" => "Liste des devoirs"
        ]);
    }

    //Creer
    /**
     * @brief Crée un nouveau devoir.
     *
     * Affiche le formulaire de création de devoir
     * en utilisant un template Twig.
     */
    public function creer(): void
    {
        $template = $this->getTwig()->load('devoir/creer.twig');

        echo $template->render([
            "titre" => "Créer un devoir"
        ]);
    }

    //Modifier
    /**
     * @brief Modifie un devoir existant.
     *
     * Affiche le formulaire de modification de devoir
     * en utilisant un template Twig.
     */
    public function modifier(): void
    {
        $template = $this->getTwig()->load('devoir/modifier.twig');

        echo $template->render([
            "titre" => "Modifier un devoir"
        ]);
    }

    //Supprimer
    /**
     * @brief Supprime un devoir existant.
     *
     * Affiche le formulaire de suppression de devoir
     * en utilisant un template Twig.
     */
    public function supprimer(): void
    {
        $template = $this->getTwig()->load('devoir/supprimer.twig');

        echo $template->render([
            "titre" => "Supprimer un devoir"
        ]);
    }
}
