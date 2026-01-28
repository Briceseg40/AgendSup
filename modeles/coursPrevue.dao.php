<?php
/**
 * @file coursprevue.dao.php
 * @brief Définit la classe CoursPrevueDAO pour l'accès aux données des cours prévus.
 */
class CoursPrevueDAO
{
    /** @brief Instance de PDO pour la connexion à la base de données */
    private ?PDO $pdo;
    
    public function __construct(?PDO $pdo = null)
    {
        $this->pdo = $pdo;
    }

    /**
     * @brief Récupère tous les cours prévus.
     * @return Cours[]
     */
    public function findAll(): array
    {
        // On trie par date de début par défaut
        $stmt = $this->pdo->prepare("SELECT * FROM coursprevue ORDER BY date_deb ASC, libelle ASC");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $coursListe = [];
        foreach ($results as $row) {
            $coursListe[] = new Cours(
                $row['id'],
                $row['date_deb'],
                $row['date_fin'],
                $row['libelle'],
                $row['description']
            );
        }

        return $coursListe;
    }

    /**
     * @brief Récupère un cours prévu par son ID.
     * @param int $id
     * @return Cours|null
     */
    public function findById(int $id): ?Cours
    {
        $stmt = $this->pdo->prepare("SELECT * FROM coursprevue WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Cours(
                $row['id'],
                $row['date_deb'],
                $row['date_fin'],
                $row['libelle'],
                $row['description']
            );
        }

        return null;
    }

    /**
     * @brief Récupère les cours compris entre deux dates.
     * @param string $dateDebut Format YYYY-MM-DD
     * @param string $dateFin Format YYYY-MM-DD
     * @return Cours[]
     */
    public function findByPeriode(string $dateDebut, string $dateFin): array
    {
        $sql = "SELECT * FROM coursprevue 
                WHERE date_deb >= :dateDebut 
                AND date_fin <= :dateFin 
                ORDER BY date_deb ASC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':dateDebut', $dateDebut);
        $stmt->bindValue(':dateFin', $dateFin);
        $stmt->execute();
        
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $listeCours = [];
        foreach ($results as $row) {
            $listeCours[] = new Cours(
                $row['id'],
                $row['date_deb'],
                $row['date_fin'],
                $row['libelle'],
                $row['description']
            );
        }
        return $listeCours; 
    }
}