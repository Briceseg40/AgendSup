<?php

class CoursDAO
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

    /** Récupère tous les cours */
    public function findAll(): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM cours ");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $cours = [];
        foreach ($results as $row) {
            $cours[] = new Cours(
                $row['id'],
                $row['libelle'],
            );
        }

        return $cours;
    }

    /** Recherche un cours par son ID */
    public function findById(int $id_cours): ?Cours
    {
        $stmt = $this->pdo->prepare("SELECT * FROM cours WHERE id = :id");
        $stmt->bindParam(':id', $id_cours, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Cours(
                $row['id'],
                $row['libelle'],
            );
        }

        return null;
    }

    /** Récupère tous les cours liés à un agenda */
    public function findByAgenda(int $id_utilisateur): array
    {
        $sql = "
            SELECT c.id, c.libelle, a.dte_cours, a.horaire_cours
            FROM afficher a
            INNER JOIN cours c ON a.id_cours = c.id
            WHERE a.id_agenda = :id_agenda
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id_agenda', $id_utilisateur, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $cours = [];
        foreach ($results as $row) {
            $cours[] = new Cours(
                $row['id'],
                $row['libelle'],
                $row['dte_cours'],
                $row['horaire_cours']
            );
        }

        return $cours;
    }
}
