<?php
/
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