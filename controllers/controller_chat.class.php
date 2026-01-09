<?php
/**
 * @file controller_chat.class.php
 * @brief Contrôleur de gestion des chats.
 *
 * Ce contrôleur permet de gérer les actions liées aux chats,
 * notamment l'affichage de la liste des chats via Twig.
 */
/**
 * @class controllerChat
 * @brief Contrôleur des chats.
 *
 * Hérite de la classe Controller.
 * Gère les actions liées aux chats (liste, affichage, etc.).
 */
class controllerChat extends Controller
{
    /**
     * @brief Constructeur du contrôleur des chats.
     *
     * @param \Twig\Loader\FilesystemLoader $loader Chargeur de templates Twig.
     * @param \Twig\Environment $twig Environnement Twig.
     */
    public function __construct(\Twig\Loader\FilesystemLoader $loader, \Twig\Environment $twig)
    {
        parent::__construct($loader, $twig);
    }

    /**
     * @brief Affiche la liste des chats.
     *
     * Récupère toutes les chats via le DAO et les affiche
     * en utilisant un template Twig.
     */
    public function lister(): void
    {
        $manager = new ChatDAO($this->getPdo());
        $chats = $manager->findAll();

        
        $template = $this->getTwig()->load('chat.twig');

        // Affichage du template et transmission des données
        echo $template->render([
            'chats' => $chats,
        ]);
    }
    // Lister les chats où un utilisateur a parlé
    // (utilisé pour afficher les chats d'un utilisateur spécifique)
    /**
     * @brief Affiche la liste des chats où un utilisateur spécifique a parlé.
     *
     * Récupère les chats via le DAO et les affiche
     * en utilisant un template Twig.
     *
     * @param int $id_utilisateur Identifiant de l'utilisateur.
     */
    public function listerByUtilisateur(int $id_utilisateur): void
    {
        $manager = new ChatDAO($this->getPdo());
        // la méthode attend un tableau d'ids, on passe un tableau avec 1 id
        $chats = $manager->findChatsOuUtilisateurAParle([$id_utilisateur]);

        $template = $this->getTwig()->load('chat.twig');

        echo $template->render([
            'chats' => $chats,
            'menu' => 'chat_by_user',
            'userId' => $id_utilisateur
        ]);
    }

    // Lister les chats où au moins un des utilisateurs du tableau a parlé
    // (utilisé pour afficher les chats d'une liste d'utilisateurs spécifiques)
    /**
     * @brief Affiche la liste des chats où au moins un des utilisateurs spécifiés a parlé.
     *
     * Récupère les chats via le DAO et les affiche
     * en utilisant un template Twig.
     *
     * @param array $userIds Tableau des identifiants des utilisateurs.
     */
    public function listerByUtilisateurs(array $userIds): void
    {
        $manager = new ChatDAO($this->getPdo());
        $chats = $manager->findChatsOuUtilisateurAParle($userIds);

        $template = $this->getTwig()->load('chat.twig');

        echo $template->render([
            'chats' => $chats,
            'menu' => 'chat_by_users'
        ]);
    }

    /*  * @brief Affiche le formulaire de création d'un chat.
     */
    public function creer(): void
    {
        $template = $this->getTwig()->load('chat/creer.twig');

        echo $template->render([
            "titre" => "Créer un chat"
        ]);
    }

    /*  * @brief Affiche le formulaire de modification d'un chat.
     */
    public function modifier(): void
    {
        $template = $this->getTwig()->load('chat/modifier.twig');

        echo $template->render([
            "titre" => "Modifier un chat"
        ]);
    }

    /**
     * @brief Affiche le formulaire de suppression d'un chat.
     */
    public function supprimer(): void
    {
        $template = $this->getTwig()->load('chat/supprimer.twig');

        echo $template->render([
            "titre" => "Supprimer un chat"
        ]);
    }
}