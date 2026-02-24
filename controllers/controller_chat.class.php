<?php
/** @file    controller_chat.class.php
* @author  Rémi Montignac
* @brief   Contrôleur pour la gestion des chats.
* @version 0.1
* @date    19/12/2025
*/
class ControllerChat extends Controller
{
    // Constructeur
    /**
     * @brief Constructeur de la classe ControllerChat.
     * @param \Twig\Loader\FilesystemLoader $loader Chargeur de fichiers Twig.
     * @param \Twig\Environment $twig Environnement Twig.
     */
    public function __construct(\Twig\Loader\FilesystemLoader $loader, \Twig\Environment $twig)
    {
        parent::__construct($loader, $twig);
    }
        
    /**
     * @brief Liste tous les chats.
     */
    public function lister(): void
    {
        $manager = new ChatDAO($this->getPdo());
        $chats = $manager->findAll();

        // Chargement du template
        $template = $this->getTwig()->load('chat.html.twig');

        // Affichage du template et transmission des données
        echo $template->render([
            'chats' => $chats,
        ]);
    }

    /**
     * @brief Liste les chats où un utilisateur spécifique a parlé.
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

    /**
     * @brief Liste les chats où au moins un des utilisateurs spécifiés a parlé.
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

    /**
     * @brief Crée un nouveau chat.
     */
    public function creer(): void
    {
        $template = $this->getTwig()->load('chat/creer.twig');

        echo $template->render([
            "titre" => "Créer un chat"
        ]);
    }

    /**
     * @brief Modifie un chat existant.
     */
    public function modifier(): void
    {
        $template = $this->getTwig()->load('chat/modifier.twig');

        echo $template->render([
            "titre" => "Modifier un chat"
        ]);
    }

    /**
     * @brief Supprime un chat existant.
     */
    public function supprimer(): void
    {
        $template = $this->getTwig()->load('chat/supprimer.twig');

        echo $template->render([
            "titre" => "Supprimer un chat"
        ]);
    }
}