<?php
class Cours
{

    private int|null $id;

   
    private string|null $libelle;

    public function __construct(?int $id = null, ?string $libelle = null)
    {
        $this->setId($id);
        $this->setLibelle($libelle);
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
}
