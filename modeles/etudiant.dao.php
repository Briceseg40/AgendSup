<?php
/**
 * @file    etudiant.dao.php
 * @author  R
 * Guénolé Mourzelas
 * @brief   Définit la classe EtudiantDAO pour gérer les opérations sur les étudiants dans la base de données.
 * @version 0.1
 * @date    19/12/2025
 */
class EtudiantDAO
{
    /**
     * Instance de PDO pour la connexion à la base de données.
     */
    private ?PDO $pdo;

    /**
     * Constructeur de la classe EtudiantDAO.
     * @param PDO|null $pdo Instance de PDO pour la connexion à la base de données.
     */
    public function __construct(?PDO $pdo = null)
    {
        $this->pdo = $pdo;
    }

    /**
     * Obtient l'instance de PDO.
     * @return PDO|null Instance de PDO.
     */
    public function getPdo(): ?PDO
    {
        return $this->pdo;
    }

    /**
     * Définit l'instance de PDO.
     * @param PDO|null $pdo Instance de PDO.
     */
    public function setPdo(?PDO $pdo): void
    {
        $this->pdo = $pdo;
    }


    public function findAll(): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM etudiant");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $etudiant = [];
        foreach ($results as $row) {
            $etudiant[] = new Etudiant(
                $row['id'],
                $row['nom'],
                $row['prenom'],
                $row['role'],
                $row['annee'],
                $row['dateNaissance'],
                $row['mail'],
                $row['mdp'],
            );
        }

        return $etudiant;
    }

    /**
     * Récupère un étudiant par son identifiant.
     * @param int $id_etudiant Identifiant de l'étudiant.
     * @return Etudiant|null Objet Etudiant ou null si non trouvé.
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
                $row['nom'],
                $row['prenom'],
                $row['role'],
                $row['annee'],
                $row['dateNaissance'],
                $row['mail'],
                $row['mdp'],
            );
        }

        return null;
    }

    /**
     * Récupère les étudiants par classe.
     * @param int $id_class Identifiant de la classe.
     * @return EtudiantDAO[] Tableau d'objets EtudiantDAO.
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
                $row['id'],
                $row['nom'],
                $row['prenom'],
                $row['role'],
                $row['Annee'],  
                $row['id_classe'],
                $row['td'],
                $row['tp'],
            );
        }

        return $etudiant;
    }

    /**
     * Récupère les étudiants par mail.
     * @param string $email email de l'étidiant.
     * @return EtudiantDAO[] Tableau d'objets EtudiantDAO.
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
                $row['date_naissance'],
                $row['mail'],
                $row['mdp']
            );
        }
        return null;
    }
}
