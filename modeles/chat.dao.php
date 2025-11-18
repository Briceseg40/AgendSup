<?php

class ChatDAO
{
    private ?PDO $pdo;

    public function __construct(?PDO $pdo = null)
    {
        $this->pdo = $pdo;
    }

    public function getPdo(): ?PDO
    {
        return $this->pdo;
    }

    public function setPdo(?PDO $pdo): void
    {
        $this->pdo = $pdo;
    }

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

    public function findChatsParUtilisateur(int $id_utilisateur): array
    {
        $sql = "
            SELECT ch.id, ch.nom
            FROM consulter co
            INNER JOIN chat ch ON co.idChat = ch.id
            WHERE co.idEtudiant = :id_utilisateur
            ORDER BY ch.nom
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT);

        try {
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur SQL : " . $e->getMessage());
            return [];
        }

        $chats = [];
        foreach ($results as $row) {
            $chats[] = new Chat(
                $row['id'],
                $row['nom']
            );
        }

        return $chats;
    }

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

    public function supprimer(int $id_chat): bool
    {
        $sql = "DELETE FROM chat WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id_chat, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
}