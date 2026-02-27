<?php
/**
 * @file    coursPrevue.class.php
 * @brief   Classe représentant un cours prévu dans l'agenda.
 */
class CoursPrevue
{
    private ?int $id;
    private ?string $date_deb;
    private ?string $date_fin;
    private ?string $heure_deb;
    private ?string $heure_fin;
    private ?string $libelle;
    private ?string $description;
    private ?string $couleur;
    private ?int $idEtudiant;
    private ?int $idClasseVirtuel;
    private ?int $idCours;

    public function __construct(?int $id = null,?string $date_deb = null,?string $date_fin = null,?string $heure_deb = null,?string $heure_fin = null,
        ?string $libelle = null,?string $description = null,?string $couleur = null,?int $idEtudiant = null,?int $idClasseVirtuel = null,
        ?int $idCours = null) {
        $this->id = $id;
        $this->date_deb = $date_deb;
        $this->date_fin = $date_fin;
        $this->heure_deb = $heure_deb;
        $this->heure_fin = $heure_fin;
        $this->libelle = $libelle;
        $this->description = $description;
        $this->couleur = $couleur;
        $this->idEtudiant = $idEtudiant;
        $this->idClasseVirtuel = $idClasseVirtuel;
        $this->idCours = $idCours;
    }

    // --- GETTERS ---
    public function getId(): ?int { 
        return $this->id; 
    }

    public function getDateDeb(): ?string { 
        return $this->date_deb; 
    }

    public function getDateFin(): ?string { 
        return $this->date_fin; 
    }
    public function getHeureDeb(): ?string { 
        return $this->heure_deb; 
    }
    public function getHeureFin(): ?string { 
        return $this->heure_fin; 
    
    }
    public function getLibelle(): ?string { return $this->libelle; }
    public function getDescription(): ?string { return $this->description; }
    public function getCouleur(): ?string { return $this->couleur; }
    public function getIdEtudiant(): ?int { return $this->idEtudiant; }
    public function getIdClasseVirtuel(): ?int { return $this->idClasseVirtuel; }
    public function getIdCours(): ?int { return $this->idCours; }

    // --- SETTERS ---
    public function setId(?int $id): void { 
        $this->id = $id; 
        }
    public function setDateDeb(?string $date_deb): void { $this->date_deb = $date_deb; }
    public function setDateFin(?string $date_fin): void { $this->date_fin = $date_fin; }
    public function setHeureDeb(?string $heure_deb): void { $this->heure_deb = $heure_deb; }
    public function setHeureFin(?string $heure_fin): void { $this->heure_fin = $heure_fin; }
    public function setLibelle(?string $libelle): void { $this->libelle = $libelle; }
    public function setDescription(?string $description): void { $this->description = $description; }
    public function setCouleur(?string $couleur): void { $this->couleur = $couleur; }
    public function setIdEtudiant(?int $idEtudiant): void { $this->idEtudiant = $idEtudiant; }
    public function setIdClasseVirtuel(?int $idClasseVirtuel): void { $this->idClasseVirtuel = $idClasseVirtuel; }
    public function setIdCours(?int $idCours): void { $this->idCours = $idCours; }
}