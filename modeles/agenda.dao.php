<?php

class AgendaDAO
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

    public function findAll(): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM agenda ORDER BY id");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $agendas = [];
        foreach ($results as $row) {
            $agendas[] = new Agenda(
                $row['id'],
                $row['mois'],
                $row['jour'],
            );
        }

        return $agendas;
    }

    public function findById(int $id_agenda): ?Agenda
    {
        $stmt = $this->pdo->prepare("SELECT * FROM agenda WHERE id = :id");
        $stmt->bindParam(':id', $id_agenda, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Agenda(
                $row['id'],
                $row['mois'],
                $row['jour'],
            );
        }

        return null;
    }

    public function findCoursParUtilisateur(int $id_utilisateur): array
    {
        $sql = "
            SELECT c.id, c.Libellé as libelle, af.date_cours, af.horaire, a.mois, a.jour
            FROM consulter co
            INNER JOIN agenda a ON co.idAgenda = a.id
            INNER JOIN afficher af ON a.id = af.id_agenda
            INNER JOIN cours c ON af.id_cours = c.id
            WHERE co.idEtudiant = :id_utilisateur
            ORDER BY af.date_cours, af.horaire
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT);
        
        try {
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur SQL : " . $e->getMessage());
            return [];
        }

        $cours = [];
        foreach ($results as $row) {
            $cours[] = [
                'id' => $row['id'],
                'libelle' => $row['libelle'],
                'date_cours' => $row['date_cours'],
                'horaire' => $row['horaire'],
                'mois' => $row['mois'],
                'jour' => $row['jour']
            ];
        }

        return $cours;
    }

    public function ajouter(Agenda $agenda): bool
    {
        $sql = "INSERT INTO agenda (id, mois, jour) VALUES (:id, :mois, :jour)";
        $stmt = $this->pdo->prepare($sql);
        $id = $agenda->getId();
        $mois = $agenda->getMois();
        $jour = $agenda->getJour();
        
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':mois', $mois, PDO::PARAM_STR);
        $stmt->bindParam(':jour', $jour, PDO::PARAM_STR);
        
        return $stmt->execute();
    }

    public function modifier(Agenda $agenda): bool
    {
        $sql = "UPDATE agenda SET mois = :mois, jour = :jour WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $id = $agenda->getId();
        $mois = $agenda->getMois();
        $jour = $agenda->getJour();
        
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':mois', $mois, PDO::PARAM_STR);
        $stmt->bindParam(':jour', $jour, PDO::PARAM_STR);
        
        return $stmt->execute();
    }

    public function supprimer(int $id_agenda): bool
    {
        $sql = "DELETE FROM agenda WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id_agenda, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
}