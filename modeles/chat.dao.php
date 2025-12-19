<?php
/**
 * @file    chat.dao.php
 * @author  Rémi Montignac
 * @brief   Définit la classe ChatDAO pour gérer les opérations sur les chtas dans la base de données.
 * @version 0.1
 * @date    19/12/2025
 */
class ChatDAO
{
    /**
     * @brief Instance de PDO pour la connexion à la base de données.
     */
    private ?PDO $pdo;

    /**
     * @brief Constructeur de la classe ChatDAO.
     * @param PDO|null $pdo Instance de PDO pour la connexion à la base de données.
     */
    public function __construct(?PDO $pdo = null)
    {
        $this->pdo = $pdo;
    }

    /**
     * @brief Obtient l'instance de PDO.
     * @return PDO|null Instance de PDO.
     */
    public function getPdo(): ?PDO
    {
        return $this->pdo;
    }

    /**
     * @brief Définit l'instance de PDO.
     * @param PDO|null $pdo Instance de PDO.
     */
    public function setPdo(?PDO $pdo): void
    {
        $this->pdo = $pdo;
    }

    /**
     * @brief Récupère tous les chats de la base de données.
     * @return Chat[] Tableau d'objets Chat.
     */
    public function findAll(): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM chat ORDER BY id");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $chats = [];
        foreach ($results as $row) {
            $chats[] = new Chat(
                $row['id'],
                $row['nom']
            );
        }

        return $chats;
    }

    /**
     * @brief Récupère un chat par son identifiant.
     * @param int $id_chat Identifiant du chat.
     * @return Chat|null Objet Chat ou null si non trouvé.
     */
    public function findById(int $id_chat): ?Chat
    {
        $stmt = $this->pdo->prepare("SELECT * FROM chat WHERE id = :id");
        $stmt->bindParam(':id', $id_chat, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Chat(
                $row['id'],
                $row['nom']
            );
        }

        return null;
    }

    /**
     * @brief Récupère tous les chats où un utilisateur a parlé.
     * @param int[] $userIds Tableau des identifiants des utilisateurs.
     * @return Chat[] Tableau d'objets Chat.
     */
    public function findChatsOuUtilisateurAParle(array $userIds): array
    {
        $userIds = array_values(array_unique($userIds));
        if (empty($userIds)) {
            return [];
        }

        $placeholders = [];
        foreach ($userIds as $i => $id) {
            $placeholders[] = ":u{$i}";
        }
        $inList = implode(',', $placeholders);

        $sql = "
            SELECT DISTINCT ch.id, ch.nom
            FROM chat ch
            INNER JOIN parler p ON p.idChat = ch.id
            WHERE p.idEtudiant IN ($inList)
            ORDER BY ch.nom
        ";

        $stmt = $this->pdo->prepare($sql);
        foreach ($userIds as $i => $id) {
            $stmt->bindValue(":u{$i}", (int)$id, PDO::PARAM_INT);
        }

        $chats = [];
        foreach ($results as $row) {
            $chats[] = new Chat($row['id'], $row['nom']);
        }

        return $chats;
    }


    /*     
     * @brief Ajoute un nouveau chat à la base de données.
     * @param Chat $chat Objet Chat à ajouter.
     * @return bool Vrai si l'ajout a réussi, faux sinon.
     */
    public function ajouter(Chat $chat): bool
    {
        $sql = "INSERT INTO chat (id, nom) VALUES (:id, :nom)";
        $stmt = $this->pdo->prepare($sql);
        $id = $chat->getId();
        $nom = $chat->getNom();
        
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
        
        return $stmt->execute();
    }

    /*     
     * @brief Modifie un chat existant dans la base de données.
     * @param Chat $chat Objet Chat à modifier.
     * @return bool Vrai si la modification a réussi, faux sinon.
     */
    public function modifier(Chat $chat): bool
    {
        $sql = "UPDATE chat SET nom = :nom WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $id = $chat->getId();
        $nom = $chat->getNom();
        
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
        
        return $stmt->execute();
    }

    /*     
     * @brief Supprime un chat de la base de données.
     * @param int $id_chat Identifiant du chat à supprimer.
     * @return bool Vrai si la suppression a réussi, faux sinon.
     */
    public function supprimer(int $id_chat): bool
    {
        $sql = "DELETE FROM chat WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id_chat, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
}