<?php

class ClasseDAO
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

    /** Récupère toutes les classes */
    public function findAll(): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM classe");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $classes = [];
        foreach ($results as $row) {
            $classes[] = new Classe(
                $row['id'],
                $row['libelle'],
            );
        }

        return $classes;
    }
}