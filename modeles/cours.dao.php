<?php
/**
 * @file    devoir.dao.php
 * @author  Rémi Bouillon
 * @brief   Définit la classe CoursDAO pour gérer les opérations sur les cours dans la base de données.
 * @version 0.1
 * @date    19/12/2025
 */
class CoursDAO
{
    /**
     * @brief Instance de PDO pour la connexion à la base de données.
     */
    private ?PDO $pdo;

    /**
     * @brief Constructeur de la classe CoursDAO.
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
     * @brief Récupère tous les cours de la base de données.
     * @return Cours[] Tableau d'objets Cours.
     */
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
            );
        }

        return $cours;
    }

    /**
     * @brief Récupère un cours par son identifiant.
     * @param int $id_cours Identifiant du cours.
     * @return Cours|null Objet Cours ou null si non trouvé.
     */
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

    /**
     * @brief Récupère tous les cours associés à un agenda spécifique.
     * @param int $id_agenda Identifiant de l'agenda.
     * @return Cours[] Tableau d'objets Cours.
     */
    public function findByAgenda(int $id_agenda): array
    {
        $sql = "
            SELECT c.id, c.libelle, a.date_cours, a.horaire
            FROM afficher a
            INNER JOIN cours c ON a.id_cours = c.id
            WHERE a.id_agenda = :id_agenda
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id_agenda', $id_agenda, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $cours = [];
        foreach ($results as $row) {
            $cours[] = new Cours(
                $row['id'],
                $row['libelle'],
                $row['date_cours'],
                $row['horaire']
            );
        }

        return $cours;
    }
}
