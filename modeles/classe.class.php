<?php

class Classe
{
    private ?int $id;
    private ?string $img;
    private ?string $titre;
    private ?string $description;
    private ?int $TD;
    private ?int $TP;
    private ?int $idEtudiant;
    private ?int $annee;
    private ?string $code;

    public function __construct( ?int $id = null, ?string $img = null, ?string $titre = null, ?string $description = null, ?int $TD = null, ?int $TP = null, ?int $idEtudiant = null, ?int $annee = null, ?string $code = null) {
        $this->id = $id;
        $this->img = $img;
        $this->titre = $titre;
        $this->description = $description;
        $this->TD = $TD;
        $this->TP = $TP;
        $this->idEtudiant = $idEtudiant;
        $this->annee = $annee;
        $this->code = $code;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getImage(): ?string
    {
        return $this->img;
    }
    public function setImage(?string $img): void
    {
        $this->img = $img;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }
    public function setTitre(?string $titre): void
    {
        $this->titre = $titre;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getTD(): ?int
    {
        return $this->TD;
    }
    public function setTD(?int $TD): void
    {
        $this->TD = $TD;
    }

    public function getTP(): ?int
    {
        return $this->TP;
    }
    public function setTP(?int $TP): void
    {
        $this->TP = $TP;
    }

    public function getIdEtudiant(): ?int
    {
        return $this->idEtudiant;
    }
    public function setIdEtudiant(?int $idEtudiant): void
    {
        $this->idEtudiant = $idEtudiant;
    }

    public function getAnnee(): ?int
    {
        return $this->annee;
    }
    public function setAnnee(?int $annee): void
    {
        $this->annee = $annee;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }
    public function setCode(?string $code): void
    {
        $this->code = $code;
    }
}
