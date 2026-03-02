<?php
/**
 * @file    etudiant.dao.php
 * @author  Guénolé Mourzelas et Baptiste Marsaa
 * @brief   Classe représentant un étudiant.
 * @details Cette classe encapsule les propriétés et méthodes
 * liées à un étudiant dans le système AgendSup.
 * @version 0.1
 * @date    19/12/2025
 */
class EtudiantDAO {
    /**
     * @brief Instance PDO pour la connexion à la base de données.
     */
    private ?PDO $pdo;
    
    /**
     * @brief Constructeur de la classe EtudiantDAO.
     * @param PDO|null $pdo Instance PDO pour la connexion à la base de données.
     */
    public function __construct(?PDO $pdo = null)
    {
        $this->pdo = $pdo;
    }

    /**
     * @brief Obtient l'instance PDO.
     * @return PDO|null Instance PDO.
     */
    public function getPdo(): ?PDO
    {
        return $this->pdo;
    }

    /**
     * @brief Définit l'instance PDO.
     * @param PDO|null $pdo Instance PDO.
     */
    public function setPdo(?PDO $pdo): void
    {
        $this->pdo = $pdo;
    }

    /** 
     * @brief Récupère tous les étudiants 
     */
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
                $row['Parcour'],
            );
        }

        return $etudiant;
    }

    public function countAll() {
        $sql = "SELECT COUNT(*) as total FROM etudiant";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetch()['total'];
    }

    
    /**
     * @brief Recherche un étudiant par son ID
     * @param integer $id_etudiant
     * @return Etudiant|null
     */
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
                $row['Parcour'],
            );
        }

        return null;
    }

    /** 
     * @brief Récupère tous les étudiants d'une classe donnée
     * @param integer $id_class
     * @return array
     */
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
                $row['id'],        // 1: id
                $row['Nom'],       // 2: Nom
                $row['Prenom'],    // 3: Prenom
                $row['role'],      // 4: role
                $row['Annee'],     // 5: Annee
                $row['idClasse'],  // 6: idClasse (DOIT ÊTRE ICI)
                $row['mail'],      // 7: mail
                $row['mdp'],       // 8: mdp
                $row['Parcour']    // 9: Parcour
                
            );
        }

        return $etudiant;
    }

    /** 
     * @brief Recherche un étudiant par son email
     * @param string $email
     * @return Etudiant|null
     */
    public function findByEmail(string $email): ?Etudiant
    {
        $stmt = $this->pdo->prepare("SELECT * FROM etudiant WHERE mail = :mail");
        $stmt->execute([':mail' => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Etudiant(
                $row['id'],        // 1: id
                $row['Nom'],       // 2: Nom
                $row['Prenom'],    // 3: Prenom
                $row['role'],      // 4: role
                $row['Annee'],     // 5: Annee
                $row['idClasse'],  // 6: idClasse
                $row['mail'],      // 7: mail
                $row['mdp'],       // 8: mdp
                $row['Parcour']    // 9: Parcour
            );
        }
        return null;
    }

    /** 
     * @brief Ajoute un nouvel étudiant à la base de données.
     * @param Etudiant $etudiant L'objet étudiant à ajouter.
     */
    public function ajouter(Etudiant $etudiant): void {
        //Hachage du mot de passe avec password_hash()
        $passwordHache = password_hash($etudiant->getMdp(), PASSWORD_BCRYPT);

        //Préparation de la requete d'insertion
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

    /**
 * @brief Supprime un étudiant
 */
public function delete(int $id): void
{
    $stmt = $this->pdo->prepare("DELETE FROM etudiant WHERE id = :id");
    $stmt->execute([':id' => $id]);
}

/**
 * @brief Modifier le rôle d’un étudiant
 */
public function updateRole(int $id, string $role): void
{
    $stmt = $this->pdo->prepare("UPDATE etudiant SET role = :role WHERE id = :id");
    $stmt->execute([
        ':role' => $role,
        ':id' => $id
    ]);
}

/**
 * @brief Modifier l’année
 */
public function updateAnnee(int $id, int $annee): void
{
    $stmt = $this->pdo->prepare("UPDATE etudiant SET Annee = :annee WHERE id = :id");
    $stmt->execute([
        ':annee' => $annenee,
        ':id' => $id
    ]);
}

/**
 * @brief Supprime complètement un compte étudiant
 */
public function supprimerCompte(int $id): bool
{
    try {
        $this->pdo->beginTransaction();

        // Supprimer d'abord les dépendances si nécessaire
        $stmt = $this->pdo->prepare("DELETE FROM devoir WHERE idEtudiant = :id");
        $stmt->execute([':id' => $id]);

        $stmt = $this->pdo->prepare("DELETE FROM messageGlobal WHERE idEtudiant = :id");
        $stmt->execute([':id' => $id]);
        
        $stmt = $this->pdo->prepare("DELETE FROM signalement WHERE idEtudiant = :id");
        $stmt->execute([':id' => $id]);
        
        // Puis supprimer l'étudiant
        $stmt = $this->pdo->prepare("DELETE FROM etudiant WHERE id = :id");
        $stmt->execute([':id' => $id]);

        $this->pdo->commit();
        return true;

    } catch (Exception $e) {
        $this->pdo->rollBack();
        return false;
    }
}
// Rechercher tous les utilisateurs en fonction de leur role année ou barre de recherche
public function findWithFilters($search, $role, $annee) {

    $sql = "SELECT * FROM etudiant WHERE 1=1";
    $params = [];

    if ($search) {
        $sql .= " AND (nom LIKE :search OR prenom LIKE :search OR mail LIKE :search)";
        $params['search'] = "%$search%";
    }

    if ($role) {
        $sql .= " AND role = :role";
        $params['role'] = $role;
    }

    if ($annee) {
        $sql .= " AND annee = :annee";
        $params['annee'] = $annee;
    }

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($params);

    return $stmt->fetchAll(PDO::FETCH_OBJ);
}
public function update($id, $nom, $prenom, $mail, $role) {

    $sql = "UPDATE etudiant 
            SET nom = :nom,
                prenom = :prenom,
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