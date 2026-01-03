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
                $row['formation'],
                $row['code']
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
                $row['formation'],
                $row['code']
            );
        }

        return $classes;
    }

     public function findCode(string $code): ?Classe
{
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
            $row['formation'],
            $row['code']
        );
    }
    return null;
}


    public function create(Classe $classe): void {
        $sql = "INSERT INTO classe (img, titre, description, idEtudiant, annee, formation, code) VALUES (:img, :titre, :description, :idEtudiant, :annee, :formation, :code)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':img' => $classe->getImage(),
            ':titre' => $classe->getTitre(),
            ':description' => $classe->getDescription(),
            ':idEtudiant' => $classe->getIdEtudiant(),
            ':annee' => $classe->getAnnee(),
            ':formation' => $classe->getFormation(),
            ':code' => $classe->getCode()
        ]);
    }
}
?>