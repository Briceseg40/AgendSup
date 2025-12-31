<?php

class EtudiantDAO
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

    /** Récupère tous les étudiants */
    public function findAll(): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM etudiant");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $etudiant = [];
        foreach ($results as $row) {
            $etudiant[] = new Etudiant(
                $row['id'],
                $row['Nom'],
                $row['Prenom'],
                $row['role'],
                $row['Annee'],
                $row['idClasse'],
                $row['mail'],
                $row['mdp'],
                $row['idClasse']
            );
        }

        return $etudiant;
    }

    /** Recherche un etudiant par son ID */
    public function findById(int $id_etudiant): ?Etudiant
    {
        $stmt = $this->pdo->prepare("SELECT * FROM etudiant WHERE id = :id");
        $stmt->bindParam(':id', $id_etudiant, PDO::PARAM_INT);
        $stmt->execute();
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
                $row['idClasse']
            );
        }

        return null;
    }

    /** Récupère tous les étudiants liés à une classe */
    public function findByClasse(int $id_class): array
    {
        $sql = "
            SELECT e.id_etudiant, e.nom_etudiant, e.prenom_etudiant, e.role_etudiant, c.id_classe, c.td_cours, c.tp_cours
            FROM classe c
            INNER JOIN etudiant e ON c.id_etudiant = e.id
            WHERE c.id_classe = :id_classe
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id_etudiant', $id_etudiant, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $etudiant = [];
        foreach ($results as $row) {
            $etudiant[] = new EtudiantDAO(
                $row['id'],
                $row['nom'],
                $row['prenom'],
                $row['role'],
                $row['Annee'],  
                $row['idClasse'],
                $row['td'],
                $row['tp'],
            );
        }

        return $etudiant;
    }

    /* Recherche un étudiant par son email */
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
                $row['idClasse']
            );
        }
        return null;
    }

    /** Insère un nouvel étudiant */
    public function insert(Etudiant $etudiant): bool
    {
        $nom = $etudiant->getNom();
        $prenom = $etudiant->getPrenom();
        $role = $etudiant->getRole();
        $annee = $etudiant->getAnnee();
        $idClasse = $etudiant->getIdClasse();
        $mail = $etudiant->getMail();
        $hashedMdp = password_hash($etudiant->getMdp(), PASSWORD_DEFAULT);

        $stmt = $this->pdo->prepare("INSERT INTO etudiant (Nom, Prenom, role, Annee, idClasse, mail, mdp) VALUES (:nom, :prenom, :role, :annee, :idClasse, :mail, :mdp)");
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':annee', $annee);
        $stmt->bindParam(':idClasse', $idClasse);
        $stmt->bindParam(':mail', $mail);
        $stmt->bindParam(':mdp', $hashedMdp);
        return $stmt->execute();
    }
}
