<?php
/**
 * @file    devoir.dao.php
 * @author  Rémi Bouillon
 * @brief   Définit la classe DevoirDAO pour gérer les opérations sur les devoirs dans la base de données.
 * @version 0.1
 * @date    19/12/2025
 */
class DevoirDAO {
    /**
     * @brief Instance de PDO pour la connexion à la base de données.
     */
    private ?PDO $pdo;

    /**
     * @brief Constructeur de la classe DevoirDAO.
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
     * @brief Récupère tous les devoirs de la base de données.
     * @return Devoir[] Tableau d'objets Devoir.
     */
    public function findAll(): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM devoir");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $devoir = [];
        foreach ($results as $row) {
            $devoir[] = new Devoir(
                $row['id'],
                $row['libelle'],
                $row['date_a_realiser'],
                $row['contenu'],
                $row['idCours']
            );
        }

        return $devoir;
    }

    /**
     * @brief Crée un nouveau devoir dans la base de données.
     * @param Devoir $devoir Objet Devoir à insérer.
     * @return bool Succès de l'opération.
     */
    public function create(Devoir $devoir): bool
    {
        $sql = "INSERT INTO devoir (libelle, date_a_realiser, contenu, idCours) VALUES (:libelle, :date_a_realiser, :contenu, :idCours)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':libelle' => $devoir->getLibelle(),
            ':date_a_realiser' => $devoir->getDateARealiser(),
            ':contenu' => $devoir->getContenu(),
            ':idCours' => $devoir->getIdCours()
        ]);
    }

    /**
     * @brief Lit un devoir spécifique dans la base de données.
     * @param int $id ID du devoir à lire.
     * @return Devoir|null Objet Devoir ou null si non trouvé.
     */
    public function read(int $id): ?Devoir
    {
        $sql = "SELECT * FROM devoir WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            return new Devoir(
                (int)$data['id'],
                $data['libelle'],
                $data['date_a_realiser'],
                $data['contenu'],
                (int)$data['idCours']
            );
        }
        return null;
    }

    /**
     * @brief Met à jour un devoir existant dans la base de données.
     * @param Devoir $devoir Objet Devoir à mettre à jour.
     * @return bool Succès de l'opération.
     */
    public function update(Devoir $devoir): bool
    {
        $sql = "UPDATE devoir SET libelle = :libelle, date_a_realiser = :date_a_realiser, contenu = :contenu, idCours = :idCours WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':libelle' => $devoir->getLibelle(),
            ':date_a_realiser' => $devoir->getDateARealiser(),
            ':contenu' => $devoir->getContenu(),
            ':idCours' => $devoir->getIdCours(),
            ':id' => $devoir->getId()
        ]);
    }

    /**
     * @brief Supprime un devoir de la base de données.
     * @param int $id ID du devoir à supprimer.
     * @return bool Succès de l'opération.
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM devoir WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    /**
     * @brief Récupère tous les devoirs de la base de données.
     * @return Devoir[] Tableau d'objets Devoir.
     */
    public function getAll(): array
    {
        $sql = "SELECT * FROM devoir";
        $stmt = $this->pdo->query($sql);
        $result = [];

        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new Devoir(
                (int)$data['id'],
                $data['libelle'],
                $data['date_a_realiser'],
                $data['contenu'],
                (int)$data['idCours']
            );
        }
        return $result;
    }
}
