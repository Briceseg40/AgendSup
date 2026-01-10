<?php
class Cours
{

    private int|null $id;
    private string|null $libelle;
    private int|null $annee;
    private string|null $parcour;
    private int|null $semestre;
    private string|null $type;

    public function __construct(?int $id = null, ?string $libelle = null, ?int $annee = null, ?string $parcour = null, ?int $semestre = null, ?string $type = null)
    {
        $this->setId($id);
        $this->setLibelle($libelle);
        $this->setAnnee($annee);
        $this->setParcour($parcour);
        $this->setSemestre($semestre);
        $this->setType($type);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle): void
    {
        $this->libelle = $libelle;
    }

    public function getAnnee(): ?int
    {
        return $this->annee;
    }

    public function setAnnee(?int $annee): void
    {
        $this->annee = $annee;
    }

    public function getParcour(): ?string
    {
        return $this->parcour;
    }

    public function setParcour(?string $parcour): void
    {
        $this->parcour = $parcour;
    }

    public function getSemestre(): ?int
    {
        return $this->semestre;
    }

    public function setSemestre(?int $semestre): void
    {
        $this->semestre = $semestre;
    }

    public function getType(): ?string
    {
        return $this->type;
    }
    
    public function setType(?string $type): void
    {
        $this->type = $type;
    }
}
