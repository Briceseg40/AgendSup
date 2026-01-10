<?php

class CoursDAO
{
    private ?PDO $pdo;

    public function __construct(?PDO $pdo = null)
    {
        $this->pdo = $pdo;
    }

    /** Récupère tous les cours avec tous les attributs */
    public function findAll(): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM cours ORDER BY semestre ASC, libelle ASC");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $cours = [];
        foreach ($results as $row) {
            // Utilisation de toutes les colonnes pour créer l'objet Cours
            $cours[] = new Cours(
                $row['id'],
                $row['libelle'],
                $row['annee'] ?? null,
                $row['parcours'] ?? null,
                $row['semestre'] ?? null,
                $row['type'] ?? null
            );
        }

        return $cours;
    }

    /** Recherche un cours complet par son ID */
    public function findById(int $id_cours): ?Cours
    {
        $stmt = $this->pdo->prepare("SELECT * FROM cours WHERE id = :id");
        $stmt->execute([':id' => $id_cours]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Cours(
                $row['id'],
                $row['libelle'],
                $row['annee'] ?? null,
                $row['parcours'] ?? null,
                $row['semestre'] ?? null,
                $row['type'] ?? null
            );
        }

        return null;
    }

    /** Récupère les cours filtrés par année et parcours sous forme d'objets */
    public function findByAnneeEtParcours(int $annee, ?string $parcours): array
    {
        $sql = "
            SELECT * FROM cours
            WHERE annee = :userAnnee 
            AND (parcours = :userParcours OR parcours IS NULL)
            ORDER BY semestre ASC, type DESC, libelle ASC;
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':userAnnee', $annee, PDO::PARAM_INT);
        $stmt->bindValue(':userParcours', $parcours, PDO::PARAM_STR);
        $stmt->execute();
        
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $listeCours = [];
        foreach ($results as $row) {
            $listeCours[] = new Cours(
                $row['id'],
                $row['libelle'],
                $row['annee'],
                $row['parcours'],
                $row['semestre'],
                $row['type']
            );
        }
        return $listeCours; 
    }
}