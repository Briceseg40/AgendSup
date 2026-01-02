<?php

class ClasseDAO {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
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
                $row['formation']
            );
        }

        return $classes;
    }

    public function findPerso(int $idEtudiant): array {
        $sql = "SELECT * FROM classe WHERE idEtudiant = $idEtudiant"; 
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
                $row['formation']
            );
        }

        return $classes;
    }
}
?>