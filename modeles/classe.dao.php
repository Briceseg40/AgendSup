<?php
/**
 * @file    classe.dao.php
 * @author  Rémi Bouillon et Brice Seguret
 * @brief   Définit la classe ClasseDAO pour gérer les opérations sur les classes dans la base de données.
 * @version 0.1
 * @date    19/12/2025
 */

class ClasseDAO {
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
    public function delete(int $id): void {
        $sql = "DELETE FROM classe WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
    }

    /**
     * @brief Trouve toutes les classes dans la base de données.
     * @return array Liste de toutes les classes.
     */
    public function findAll() {
        $sql = "SELECT * FROM classe"; 
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $classes = [];
        foreach ($rows as $row) {
            $classes[] = new Classe(
                $row['id'],
                $row['img'],
                $row['titre'],
                $row['description'],
                $row['TD'],
                $row['TP'],
                $row['idEtudiant'],
                $row['annee'],
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
        $sql = "SELECT * FROM classe WHERE idEtudiant = :id"; 
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $idEtudiant]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $classes = [];
        foreach ($rows as $row) {
            $classes[] = new Classe(
                $row['id'],
                $row['img'],
                $row['titre'],
                $row['description'],
                $row['TD'],
                $row['TP'],
                $row['idEtudiant'],
                $row['annee'],
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
    public function findCode(string $code): ?Classe {
        $sql = "SELECT * FROM classe WHERE code = :code";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':code' => $code]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Classe(
                $row['id'],
                $row['img'],
                $row['titre'],
                $row['description'],
                $row['TD'],
                $row['TP'],
                $row['idEtudiant'],
                $row['annee'],
                $row['code']
            );
        }
        return null;
    }

    /**
     * @brief Crée une nouvelle classe dans la base de données.
     * @param Classe $classe Objet Classe à insérer.
     */
    public function create(Classe $classe): void {
        $sql = "INSERT INTO classe (img, titre, description, TD, TP, idEtudiant, annee, code) VALUES (:img, :titre, :description, :TD, :TP, :idEtudiant, :annee, :code)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':img' => $classe->getImage(),
            ':titre' => $classe->getTitre(),
            ':description' => $classe->getDescription(),
            ':TD' => $classe->getTD(),
            ':TP' => $classe->getTP(),
            ':idEtudiant' => $classe->getIdEtudiant(),
            ':annee' => $classe->getAnnee(),
            ':code' => $classe->getCode()
        ]);
    }
}