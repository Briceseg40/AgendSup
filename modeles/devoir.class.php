<?php

class Devoir {
    //Attributs
    private int|null $id;
    private string|null $libelle;
    private string|null $date_deb;
    private string|null $date_fin;
    private string|null $heure_deb;
    private string|null $heure_fin;
    private string|null $contenu;
    private string|null $couleur;
    private int|null $idCours;
    private int|null $idClasse;
    private int|null $idEtudiant;

    //Constructeur
    public function __construct(?int $id = null, ?string $libelle = null, ?string $date_deb = null,?string $date_fin = null,?string $heure_deb = null,?string $heure_fin = null, ?string $contenu = null, ?string $couleur = null, ?int $idCours = null, ?int $idClasse = null, ?int $idEtudiant = null) {
        $this->id = $id;
        $this->libelle = $libelle;
        $this->date_deb = $date_deb;
        $this->date_fin = $date_fin;
        $this->heure_deb = $heure_deb;
        $this->heure_fin = $heure_fin;
        $this->contenu = $contenu;  
        $this->couleur = $couleur;
        $this->idCours = $idCours;
        $this->idClasse = $idClasse;
        $this->idEtudiant = $idEtudiant;
    }

    //Getters et Setters 
    public function getId(): ?int 
    {
        return $this->id;
    }

    public function setId(int $id): void 
    {
        $this->id = $id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): void
    {
        $this->libelle = $libelle;
    }

    public function getDateDeb(): string
    {
        return $this->date_deb;
    }

    public function setDateDeb(string $date_deb): void
    {
        $this->date_deb = $date_deb;
    }
    
    public function getDatefin(): string
    {
        return $this->date_fin;
    }

    public function setDateFin(string $date_fin): void
    {
        $this->date_fin = $date_fin;
    }

    public function getHeureDeb(): string
    {
        return $this->heure_deb;
    }

    public function setHeureDeb(string $heure_deb): void
    {
        $this->heure_deb = $heure_deb;
    }


    public function getHeureFin(): string
    {
        return $this->heure_fin;
    }

    public function setHeureFin(string $heure_fin): void
    {
        $this->heure_fin = $heure_fin;
    }


    public function getContenu(): string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): void
    {
        $this->contenu = $contenu;
    }


    public function setCouleur(string $couleur): void
    {
        $this->couleur = $couleur;
    }

    public function getCouleur(): string
    {
        return $this->couleur;
    }

  
    public function getIdCours(): int
    {
        return $this->idCours;
    }

    public function setIdCours(int $idCours): void
    {
        $this->idCours = $idCours;
    }

    public function getIdClasse(): int
    {
        return $this->idClasse;
    }

    public function setIdClasse(int $idClasse): void
    {
        $this->idClasse = $idClasse;
    }

    public function getIdEtudiant(): int
    {
        return $this->idEtudiant;
    }

    public function setIdEtudiant(int $idEtudiant): void
    {
        $this->idEtudiant = $idEtudiant;
    }

    //Méthode usuelles
    public function __toString(): string {
        return "Devoir [id={$this->id}, libelle={$this->libelle}, date_deb={$this->date_deb}, date_fin={$this->date_fin},heure_deb={$this->heure_deb},date_fin={$this->date_fin},contenu={$this->contenu}, couleur={$this->couleur}, idCours={$this->idCours}, idClasse={$this->idClasse}]";
    }
}
