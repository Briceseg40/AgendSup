<?php

class controllerChat extends Controller
{
    public function __construct(\Twig\Loader\FilesystemLoader $loader, \Twig\Environment $twig)
    {
        parent::__construct($loader, $twig);
    }

    // Lister tous les chats
    public function lister(): void
    {
        $manager = new ChatDAO($this->getPdo());
        $chats = $manager->findAll();

        // Chargement du template
        $template = $this->getTwig()->load('chat.twig');

        // Affichage du template et transmission des données
        echo $template->render([
            'chats' => $chats,
        ]);
    }

    // Lister les chats où un utilisateur a parlé (utiliser l'id unique)
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

    // Creer
    public function creer(): void
    {
        $template = $this->getTwig()->load('chat/creer.twig');

        echo $template->render([
            "titre" => "Créer un chat"
        ]);
    }

    // Modifier
    public function modifier(): void
    {
        $template = $this->getTwig()->load('chat/modifier.twig');

        echo $template->render([
            "titre" => "Modifier un chat"
        ]);
    }

    // Supprimer
    public function supprimer(): void
    {
        $template = $this->getTwig()->load('chat/supprimer.twig');

        echo $template->render([
            "titre" => "Supprimer un chat"
        ]);
    }
}