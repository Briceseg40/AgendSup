<?php

class DevoirDAO {

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

    // Crée un nouveau devoir
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

    // Récupère un devoir par son id
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

    // Met à jour un devoir existant
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

    // Supprime un devoir par son id
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM devoir WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    // Récupère tous les devoirs
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
