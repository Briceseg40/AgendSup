<?php

class Agenda
{
    private int|null $id;
    private string|null $mois;
    private string|null $jour;

    public function __construct(?int $id = null, ?string $mois = null, ?string $jour = null)
    {
        $this->setId($id);
        $this->setMois($mois);
        $this->setJour($jour);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getMois(): ?string
    {
        return $this->mois;
    }

    public function setMois(?string $mois): void
    {
        $this->mois = $mois;
    }

    public function getJour(): ?string
    {
        return $this->jour;
    }

    public function setJour(?string $jour): void
    {
        $this->jour = $jour;
    }
}