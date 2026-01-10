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
        $stmt = $this->pdo->prepare("SELECT * FROM cours");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $cours = [];
        foreach ($results as $row) {
            $cours[] = new Cours(
                $row['id'],
                $row['libelle'],
                $row['']
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
    public function findByAnneeEtParcours(int $annee, ?string $parcours): array
    {
    // 1. La requête adaptée à ta structure (libelle contient le code + nom)
    $sql = "
        SELECT id, libelle, type, semestre 
        FROM cours
        WHERE annee = :userAnnee 
        AND (parcours = :userParcours OR parcours IS NULL)
        ORDER BY semestre ASC, type DESC, libelle ASC;
    ";

    $stmt = $this->pdo->prepare($sql);
    
    // 2. On lie les bons paramètres
    $stmt->bindValue(':userAnnee', $annee, PDO::PARAM_INT);
    $stmt->bindValue(':userParcours', $parcours, PDO::PARAM_STR);
    
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 3. On retourne les résultats (soit en tableau simple, soit en objet)
    // Si tu utilises une classe "Cours", assure-toi que le constructeur accepte ces données
    return $results; 
    }

}
