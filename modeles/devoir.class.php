<?php

class Devoir {
    //Attributs
    private int $id;
    private string $libelle;
    private string $date_a_realiser;
    private string $contenu;
    private int $idCours;

    //Constructeur
    public function __construct(?int $id = null, ?string $libelle = null, ?string $date_a_realiser = null, ?string $contenu = null, ?int $idCours = null) {
        $this->id = $id;
        $this->libelle = $libelle;
        $this->date_a_realiser = $date_a_realiser;
        $this->contenu = $contenu;
        $this->idCours = $idCours;
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

    public function getDateARealiser(): string
    {
        return $this->date_a_realiser;
    }

    public function setDateARealiser(string $date_a_realiser): void
    {
        $this->date_a_realiser = $date_a_realiser;
    }

    public function getContenu(): string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): void
    {
        $this->contenu = $contenu;
    }

    public function getIdCours(): int
    {
        return $this->idCours;
    }

    public function setIdCours(int $idCours): void
    {
        $this->idCours = $idCours;
    }

    //Méthode usuelles
    public function __toString(): string {
        return "Devoir [id={$this->id}, libelle={$this->libelle}, date_a_realiser={$this->date_a_realiser}, contenu={$this->contenu}, idCours={$this->idCours}]";
    }
}
