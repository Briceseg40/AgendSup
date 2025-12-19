<?php
/**
 * @file    classe.dao.php
 * @author  Rémi Bouillon
 * @brief   Définit la classe ClasseDAO pour gérer les opérations sur les classes dans la base de données.
 * @version 0.1
 * @date    19/12/2025
 */
class ClasseDAO
{
    /**
     * @brief Instance de PDO pour la connexion à la base de données.
     */
    private ?PDO $pdo;

    /**
     * @brief Constructeur de la classe ClasseDAO.
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
     * @brief Récupère toutes les classes de la base de données.
     * @return Classe[] Tableau d'objets Classe.
     */
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