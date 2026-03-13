<?php
/**
 * @file    etudiant.dao.php
 * @brief   Classe DAO pour la gestion des étudiants.
 */
class EtudiantDAO {
    private ?PDO $pdo;
    
    public function __construct(?PDO $pdo = null)
    {
        $this->pdo = $pdo;
    }

    public function getPdo(): ?PDO { return $this->pdo; }
    public function setPdo(?PDO $pdo): void { $this->pdo = $pdo; }

    /** * @brief Récupère tous les étudiants 
     */
    public function findAll(): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM etudiant");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $etudiants = [];
        foreach ($results as $row) {
            $etudiants[] = new Etudiant(
                $row['id'],
                $row['Nom'],
                $row['Prenom'],
                $row['role'],
                $row['Annee'],
                $row['idClasse'],
                $row['mail'],
                $row['mdp'],
                $row['Parcour']
            );
        }
        return $etudiants;
    }

    public function countAll() {
        $sql = "SELECT COUNT(*) as total FROM etudiant";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetch()['total'];
    }

    /**
     * @brief Recherche un étudiant par son ID
     */
    public function findById(int $id_etudiant): ?Etudiant
    {
        $stmt = $this->pdo->prepare("SELECT * FROM etudiant WHERE id = :id");
        $stmt->execute([':id' => $id_etudiant]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Etudiant(
                $row['id'],
                $row['Nom'],
                $row['Prenom'],
                $row['role'],
                $row['Annee'],
                $row['idClasse'],
                $row['mail'],
                $row['mdp'],
                $row['Parcour']
            );
        }
        return null;
    }

    /** * @brief Récupère tous les étudiants d'une classe donnée
     */
    public function findByClasse(int $id_classe): array
    {
        // Correction de la requête : tout en minuscules et jointure cohérente
        $sql = "SELECT e.* FROM etudiant e WHERE e.idClasse = :id_classe";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id_classe' => $id_classe]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $etudiants = [];
        foreach ($results as $row) {
            $etudiants[] = new Etudiant(
                $row['id'],
                $row['Nom'],
                $row['Prenom'],
                $row['role'],
                $row['Annee'],
                $row['idClasse'],
                $row['mail'],
                $row['mdp'],
                $row['Parcour']
            );
        }
        return $etudiants;
    }

    /** * @brief Recherche un étudiant par son email
     */
    public function findByEmail(string $email): ?Etudiant
    {
        $stmt = $this->pdo->prepare("SELECT * FROM etudiant WHERE mail = :mail");
        $stmt->execute([':mail' => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Etudiant(
                $row['id'],
                $row['Nom'],
                $row['Prenom'],
                $row['role'],
                $row['Annee'],
                $row['idClasse'],
                $row['mail'],
                $row['mdp'],
                $row['Parcour']
            );
        }
        return null;
    }

    public function ajouter(Etudiant $etudiant): void {
        $passwordHache = password_hash($etudiant->getMdp(), PASSWORD_BCRYPT);

        $requete = $this->pdo->prepare(
            'INSERT INTO etudiant (Nom, Prenom, mail, mdp, role, Annee, idClasse, Parcour)
             VALUES (:Nom, :Prenom, :mail, :mdp, :role, :Annee, :idClasse, :Parcour)'
        );

        $requete->execute([
            ':Nom' => $etudiant->getNom(),
            ':Prenom' => $etudiant->getPrenom(),
            ':role' => $etudiant->getRole(),
            ':Annee' => $etudiant->getAnnee(),
            ':idClasse' => $etudiant->getIdClasse(),
            ':mail' => $etudiant->getMail(),
            ':mdp' => $passwordHache,
            ':Parcour' => $etudiant->getParcour()
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM etudiant WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }

    public function updateRole(int $id, string $role): void
    {
        $stmt = $this->pdo->prepare("UPDATE etudiant SET role = :role WHERE id = :id");
        $stmt->execute([':role' => $role, ':id' => $id]);
    }

    public function updateAnnee(int $id, int $annee): void
    {
        // Correction de la variable $annenee -> $annee
        $stmt = $this->pdo->prepare("UPDATE etudiant SET Annee = :annee WHERE id = :id");
        $stmt->execute([':annee' => $annee, ':id' => $id]);
    }

    public function supprimerCompte(int $id): bool
    {
        try {
            $this->pdo->beginTransaction();

            $stmt = $this->pdo->prepare("DELETE FROM devoir WHERE idEtudiant = :id");
            $stmt->execute([':id' => $id]);

            $stmt = $this->pdo->prepare("DELETE FROM messageGlobal WHERE idEtudiant = :id");
            $stmt->execute([':id' => $id]);
            
            $stmt = $this->pdo->prepare("DELETE FROM signalement WHERE idEtudiant = :id");
            $stmt->execute([':id' => $id]);
            
            $stmt = $this->pdo->prepare("DELETE FROM etudiant WHERE id = :id");
            $stmt->execute([':id' => $id]);

            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            return false;
        }
    }

    public function findWithFilters($search, $role, $annee) {
        $sql = "SELECT * FROM etudiant WHERE 1=1";
        $params = [];

        if ($search) {
            $sql .= " AND (Nom LIKE :search OR Prenom LIKE :search OR mail LIKE :search)";
            $params['search'] = "%$search%";
        }

        if ($role) {
            $sql .= " AND role = :role";
            $params['role'] = $role;
        }

        if ($annee) {
            $sql .= " AND Annee = :annee";
            $params['annee'] = $annee;
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function update($id, $nom, $prenom, $mail, $role) {
        $sql = "UPDATE etudiant 
                SET Nom = :nom,
                    Prenom = :prenom,
                    mail = :mail,
                    role = :role
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'id' => $id,
            'nom' => $nom,
            'prenom' => $prenom,
            'mail' => $mail,
            'role' => $role
        ]);
    }
}