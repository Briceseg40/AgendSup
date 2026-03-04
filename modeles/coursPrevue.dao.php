<?php
class CoursPrevueDAO
{
    private ?PDO $pdo;
    
    public function __construct(?PDO $pdo = null)
    {
        $this->pdo = $pdo;
    }

    /**
     * @brief Récupère tous les cours prévus.
     */
    public function findAll(): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM coursprevue ORDER BY date_deb ASC, heure_deb ASC");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $coursListe = [];
        foreach ($results as $row) {
            $coursListe[] = new CoursPrevue(
                $row['id'], $row['date_deb'], $row['date_fin'], $row['heure_deb'], 
                $row['heure_fin'], $row['libelle'], $row['description'], 
                $row['Couleur'], $row['idEtudiant'], $row['idClasseVirtuel'], $row['idCours']
            );
        }
        return $coursListe;
    }

    /**
     * @brief Récupère les cours pour une classe virtuelle spécifique.
     */
    public function findByClasse(int $idClasse): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM coursprevue join ETUDIANT on coursprevue.idEtudiant = ETUDIANT.id WHERE Etudiant.idClasse = :idClasse");
        $stmt->execute([':idClasse' => $idClasse]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $events = [];
        foreach ($results as $row) {
            $events[] = new CoursPrevue(
            $row['id'],
            $row['date_deb'],
            $row['date_fin'],
            $row['heure_deb'],
            $row['heure_fin'],
            $row['libelle'],
            $row['description'],
            $row['Couleur']
            );
        }
        return $events;
    }

 public function findByEtudiant(int $idEtudiant): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM coursprevue WHERE idEtudiant = :idEtudiant");
        $stmt->execute([':idEtudiant' => $idEtudiant]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $events = [];
        foreach ($results as $row) {
            $events[] = new CoursPrevue(
            $row['id'],
            $row['date_deb'],
            $row['date_fin'],
            $row['heure_deb'],
            $row['heure_fin'],
            $row['libelle'],
            $row['description'],
            $row['Couleur']
        );
        }
        return $events;
    }

    public function findByID(int $id): ?CoursPrevue
    {
        $stmt = $this->pdo->prepare("SELECT * FROM coursprevue WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
        return null;
        }

        return new CoursPrevue(
            $row['id'],
            $row['date_deb'],
            $row['date_fin'],
            $row['heure_deb'],
            $row['heure_fin'],
            $row['libelle'],
            $row['description'],
            $row['Couleur'],
            $row['idEtudiant'],
            $row['idClasseVirtuel'],
            $row['idCours']
            );
    }


    /**
     * @brief Crée un nouveau cours prévu.
     */
    public function create(CoursPrevue $cours): bool
    {
        $sql = "INSERT INTO coursprevue (date_deb, date_fin, heure_deb, heure_fin, libelle, description, Couleur, idEtudiant, idClasseVirtuel, idCours) 
                VALUES (:date_deb, :date_fin, :heure_deb, :heure_fin, :libelle, :description, :couleur, :idEtudiant, :idClasseVirtuel, :idCours)";
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':date_deb'         => $cours->getDateDeb(),
            ':date_fin'         => $cours->getDateFin(),
            ':heure_deb'        => $cours->getHeureDeb(),
            ':heure_fin'        => $cours->getHeureFin(),
            ':libelle'          => $cours->getLibelle(),
            ':description'      => $cours->getDescription(),
            ':couleur'          => $cours->getCouleur(),
            ':idEtudiant'       => $cours->getIdEtudiant(),
            ':idClasseVirtuel'  => $cours->getIdClasseVirtuel(),
            ':idCours'          => $cours->getIdCours()
        ]);
    }

    /**
     * @brief Met à jour un cours prévu.
     */
    public function update(CoursPrevue $cours): bool
    {
        $sql = "UPDATE coursprevue SET 
                date_deb = :date_deb, date_fin = :date_fin, heure_deb = :heure_deb, 
                heure_fin = :heure_fin, libelle = :libelle, description = :description, 
                Couleur = :couleur, idEtudiant = :idEtudiant, idClasseVirtuel = :idClasseVirtuel, 
                idCours = :idCours WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':date_deb'         => $cours->getDateDeb(),
            ':date_fin'         => $cours->getDateFin(),
            ':heure_deb'        => $cours->getHeureDeb(),
            ':heure_fin'        => $cours->getHeureFin(),
            ':libelle'          => $cours->getLibelle(),
            ':description'      => $cours->getDescription(),
            ':couleur'          => $cours->getCouleur(),
            ':idEtudiant'       => $cours->getIdEtudiant(),
            ':idClasseVirtuel'  => $cours->getIdClasseVirtuel(),
            ':idCours'          => $cours->getIdCours(),
            ':id'               => $cours->getId()
        ]);
    }

    /**
     * @brief Supprime un cours prévu.
     */
    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM coursprevue WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}