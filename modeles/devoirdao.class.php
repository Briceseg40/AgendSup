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

    /** Récupère tous les cours */
    public function findByClasse(int $idClasse): array
    {
        // On prépare la requête avec le marqueur :idClasse
        $stmt = $this->pdo->prepare("SELECT * FROM devoir WHERE idClasse = :idClasse");
        
        // CORRECTION : Il faut passer la valeur dans un tableau au moment du execute()
        $stmt->execute([':idClasse' => $idClasse]); 
        
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        $devoirs = [];
        foreach ($results as $row) {
            $devoirs[] = new Devoir(
                $row['id'],
                $row['libelle'],
                $row['date_deb'],
                $row['date_fin'],
                $row['heure_deb'],
                $row['heure_fin'],
                $row['contenu'],
                $row['Couleur'],
                $row['idCours'],
                $row['idClasse'],
                $row['idEtudiant']
            );
        }
    
        return $devoirs;
    }


    public function findById(int $id): ?Devoir
{
    // On utilise :id pour correspondre à la clé du tableau execute
    $stmt = $this->pdo->prepare("SELECT * FROM devoir WHERE id = :id");
    $stmt->execute([':id' => $id]); 
    
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        return null;
    }

    // On retourne DIRECTEMENT l'objet Devoir
    return new Devoir(
        $row['id'],
        $row['libelle'],
        $row['date_deb'],
        $row['date_fin'],
        $row['heure_deb'],
        $row['heure_fin'],
        $row['contenu'],
        $row['Couleur'],
        $row['idCours'],
        $row['idClasse'],
        $row['idEtudiant']
    );
}


    // Crée un nouveau devoir
    // Crée un nouveau devoir
    public function create(Devoir $devoir): bool
    {
        // 1. Correction de la requête SQL (Ajout de la virgule entre date_fin et heure_deb, et du : devant heure_fin)
        $sql = "INSERT INTO devoir (libelle, date_deb, date_fin, heure_deb, heure_fin, contenu, Couleur, idCours, idClasse,idEtudiant) 
                VALUES (:libelle, :date_deb, :date_fin, :heure_deb, :heure_fin, :contenu, :couleur, :idCours, :idClasse,:idEtudiant)";
        
        $stmt = $this->pdo->prepare($sql);
        
        // 2. Alignement strict du tableau de données
        return $stmt->execute([
            ':libelle'   => $devoir->getLibelle(),
            ':date_deb'  => $devoir->getDateDeb(),
            ':date_fin'  => $devoir->getDatefin(),
            ':heure_deb' => $devoir->getHeureDeb(),
            ':heure_fin' => $devoir->getHeureFin(),
            ':contenu'   => $devoir->getContenu(),
            ':couleur'   => $devoir->getCouleur(),
            ':idCours'   => $devoir->getIdCours(),
            ':idClasse'  => $devoir->getIdClasse(),
            ':idEtudiant'=> $devoir->getIdEtudiant()
        ]);
    }

    public function findByEtudiant(int $idEtudiant): array
    {
        $sql = "SELECT * 
                FROM devoir
                WHERE idEtudiant = :idEtudiant";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':idEtudiant' => $idEtudiant]);
        
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $devoirs = [];
        
        foreach ($results as $row) {
            $devoirs[] = new Devoir(
                $row['id'],
                $row['libelle'],
                $row['date_deb'],
                $row['date_fin'],
                $row['heure_deb'],
                $row['heure_fin'],
                $row['contenu'],
                $row['Couleur'],
                $row['idCours'],
                $row['idClasse'],
                $row['idEtudiant']
            );
        }
        
        return $devoirs;
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
    // 1. Définition de la requête avec TOUS les marqueurs nécessaires
    $sql = "UPDATE devoir 
            SET libelle = :libelle, 
                date_deb = :date_deb, 
                date_fin = :date_fin, 
                heure_deb = :heure_deb, 
                heure_fin = :heure_fin, 
                contenu = :contenu, 
                Couleur = :couleur, 
                idCours = :idCours, 
                idClasse = :idClasse, 
                idEtudiant = :idEtudiant
            WHERE id = :id";

    $stmt = $this->pdo->prepare($sql);

    // 2. Mapping strict : chaque marqueur ci-dessus doit être une clé ici
    return $stmt->execute([
        ':libelle'    => $devoir->getLibelle(),
        ':date_deb'   => $devoir->getDateDeb(),
        ':date_fin'   => $devoir->getDateFin(),
        ':heure_deb'  => $devoir->getHeureDeb(),
        ':heure_fin'  => $devoir->getHeureFin(),
        ':contenu'    => $devoir->getContenu(),
        ':couleur'    => $devoir->getCouleur(),
        ':idCours'    => $devoir->getIdCours(),
        ':idClasse'   => $devoir->getIdClasse(),
        ':idEtudiant' => $devoir->getIdEtudiant(),
        ':id'         => $devoir->getId()
    ]);
}

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM devoir WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        
        // On lie l'ID pour éviter les injections SQL
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
                $data['date_deb'],
                $data['date_fin'],
                $data['heure_deb'],
                $data['heure_fin'],
                $data['contenu'],
                $data['couleur'],
                (int)$data['idCours'],
                (int)$data['idClasse'],
                (int)$data['idEtudiant']
            );
        }
        return $result;
    }
}
