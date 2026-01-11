<?php

class ClasseDAO {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function delete(int $id): void {
        $sql = "DELETE FROM classe WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
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