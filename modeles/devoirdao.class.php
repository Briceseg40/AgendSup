<?php
/**
 * @file    devoirdao.class.php
 * @author  Rémi Bouillon
 * @brief   Classe représentant un étudiant.
 * @details Cette classe encapsule les propriétés et méthodes
 * liées à un étudiant dans le système AgendSup.
 * @version 0.1
 * @date    19/12/2025
 */
class DevoirDAO {
    /**
     * @brief Instance PDO pour la connexion à la base de données.
     */
    private ?PDO $pdo;

    /**
     * @brief Constructeur de la classe DevoirDAO.
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
     * @brief Récupère les classes.
     * @param integer $idClasse
     * @return array
     */
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
    
    /**
     * @brief Récupère un devoir par son id
     *
     * @param integer $id
     * @return Devoir|null
     */
    public function findById(int $id): ?Devoir{
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


    /**
     * @brief Crée un nouveau devoir dans la base de données.
     *
     * @param Devoir $devoir L'objet Devoir à insérer.
     * @return bool Retourne true si l'insertion a réussi, false sinon.
     */
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

    /**
     * @brief Récupère les devoirs d'un étudiant donné.
     *
     * @param int $idEtudiant Identifiant de l'étudiant.
     * @return array Liste des devoirs associés à l'étudiant.
     */
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

    /**
     * @brief Récupère un devoir par son identifiant.
     *
     * @param int $id Identifiant du devoir.
     * @return Devoir|null Objet Devoir si trouvé, sinon null.
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
     * @brief Met à jour un devoir dans la base de données.
     *
     * @param Devoir $devoir L'objet Devoir à mettre à jour.
     * @return bool Retourne true si la mise à jour a réussi, false sinon.
     */
    public function update(Devoir $devoir): bool{
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

    /**
     * @brief Supprime un devoir de la base de données.
     *
     * @param int $id Identifiant du devoir à supprimer.
     * @return bool Retourne true si la suppression a réussi, false sinon.
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM devoir WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        
        // On lie l'ID pour éviter les injections SQL
        return $stmt->execute([':id' => $id]);
    }
 
    /**
     * @brief Récupère tous les devoirs de la base de données.
     *
     * @return array Liste de tous les devoirs.
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
