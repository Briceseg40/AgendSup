<?php
/**
 * @file    classe.dao.php
 * @author  Rémi Bouillon et Brice Seguret
 * @brief   Définit la classe ClasseDAO pour gérer les opérations sur les classes dans la base de données.
 * @version 0.1
 * @date    19/12/2025
 */

class ClasseVirtuelDAO {
    /**
     * @brief Instance de PDO pour la connexion à la base de données.
     */
    private $pdo;
    /**
     * @brief Constructeur de la classe ClasseDAO.
     * @param PDO $pdo Instance de PDO pour la connexion à la base de données.
     */
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    /**
     * @brief Supprime une classe par son ID.
     * @param int $id Identifiant de la classe à supprimer.
     */
    
/**
     * @brief Crée une nouvelle classe dans la base de données.
     * @param Classe $classe Objet Classe à insérer.
     */
    public function create(classeVirtuel $classe): void {

        $user = $_SESSION['user'];
        // 1. Créer la classe
        $sql = "INSERT INTO classeVirtuel (img, titre, description, idCreateur, idClasse, code) 
        VALUES (:img, :titre, :description, :idCreateur, :idClasse, :code)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':img' => $classe->getImage(),
            ':titre' => $classe->getTitre(),
            ':description' => $classe->getDescription(),
            ':idClasse' => $classe->getIdClasse(),
            ':idCreateur' => $user->getId(),
            ':code' => $classe->getCode()
        ]);

        // 2. Inscrire automatiquement le créateur dans sa classe
        $idClasse = $this->pdo->lastInsertId();
        $this->rejoindre($user->getId(), $idClasse);
    }

    // Nouvelle méthode pour s'inscrire
    public function rejoindre(int $idEtudiant, int $idClasse): void {
        // On ignore les erreurs si on est déjà inscrit
        $sql = "INSERT IGNORE INTO inscription (id_etudiant, id_classe) VALUES (:ide, :idc)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':ide' => $idEtudiant, ':idc' => $idClasse]);
    }

    // Nouvelle méthode pour se désinscrire (au lieu de tout supprimer)
    public function delete(int $idEtudiant, int $idClasse): void {
        $sql = "DELETE FROM inscription WHERE id_etudiant = :ide AND id_classe = :idc";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':ide' => $idEtudiant, ':idc' => $idClasse]);
    }

    public function findInscrites(int $idEtudiant): array {
        $sql = "SELECT c.*, e.Nom as nomCreateur, e.Prenom as prenomCreateur
                FROM classeVirtuel c 
                JOIN inscription i ON c.id = i.id_classe 
                JOIN etudiant e ON e.id = c.idCreateur
                WHERE i.id_etudiant = :id";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $idEtudiant]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        $classes = [];
        foreach ($rows as $row) {
            // 1. Créer l'objet d'abord
            $classeObj = new ClasseVirtuel(
                $row['id'],
                $row['img'],
                $row['titre'],
                $row['description'],
                $row['idClasse'],
                $row['idCreateur'],
                $row['code']
            );
    
            $classeObj->nomCreateur = $row['nomCreateur'] ?? 'Inconnu';
            $classeObj->prenomCreateur = $row['prenomCreateur'] ?? '';
    
            $classes[] = $classeObj;
        }
        return $classes;
    }

    /**
     * @brief Trouve toutes les classes dans la base de données.
     * @return array Liste de toutes les classes.
     */
    public function findAll() {
        $sql = "SELECT * FROM classeVirtuel "; 
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $classes = [];
        foreach ($rows as $row) {
            $classes[] = new ClasseVirtuel(
                $row['id'],
                $row['img'],
                $row['titre'],
                $row['description'],
                $row['idClasse'],
                $row['idCreateur'],                
                $row['code']
            );
        }
        return $classes;
    }

    /**
     * @brief Trouve toutes les classes associées à un étudiant donné.
     * @param int $idEtudiant Identifiant de l'étudiant.
     * @return array Liste des classes associées à l'étudiant.
     */
    public function findPerso(int $idEtudiant): array {
        $sql = "SELECT * FROM classeVirtuel WHERE idCreateur = :id"; 
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $idEtudiant]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $classes = [];
        foreach ($rows as $row) {
            $classes[] = new ClasseVirtuel(
                $row['id'],
                $row['img'],
                $row['titre'],
                $row['description'],
                $row['idClasse'],
                $row['idCreateur'],                
                $row['code']
            );
        }
        return $classes;
    }

    /**
     * @brief Trouve une classe par son code unique.
     * @param string $code Code unique de la classe.
     * @return Classe|null La classe trouvée ou null si elle n'existe pas.
     */
    public function findCode(string $code): ?ClasseVirtuel {
        $sql = "SELECT * FROM classeVirtuel WHERE code = :code";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':code' => $code]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new ClasseVirtuel(
                $row['id'],
                $row['img'],
                $row['titre'],
                $row['description'],
                $row['idClasse'],
                $row['idCreateur'],                
                $row['code']
            );
        }
        return null;
    }

    
    
}