<?php

class ClasseDAO {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function create(Classe $classe): void {
        // 1. Créer la classe
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

        // 2. Inscrire automatiquement le créateur dans sa classe
        $idClasse = $this->pdo->lastInsertId();
        $this->rejoindre($classe->getIdEtudiant(), $idClasse);
    }

    // Nouvelle méthode pour s'inscrire
    public function rejoindre(int $idEtudiant, int $idClasse): void {
        // On ignore les erreurs si on est déjà inscrit
        $sql = "INSERT IGNORE INTO inscription (id_etudiant, id_classe) VALUES (:ide, :idc)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':ide' => $idEtudiant, ':idc' => $idClasse]);
    }

    // Nouvelle méthode pour se désinscrire (au lieu de tout supprimer)
    // J'ai gardé le nom 'delete' comme tu voulais
    public function delete(int $idEtudiant, int $idClasse): void {
        $sql = "DELETE FROM inscription WHERE id_etudiant = :ide AND id_classe = :idc";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':ide' => $idEtudiant, ':idc' => $idClasse]);
    }

    public function findInscrites(int $idEtudiant): array {
        $sql = "SELECT c.* FROM classe c 
                JOIN inscription i ON c.id = i.id_classe 
                WHERE i.id_etudiant = :id";
        
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
}