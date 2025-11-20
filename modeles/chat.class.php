<?php

class Chat
{
    private int|null $id;
    private string|null $nom;

    public function __construct(?int $id = null, ?string $nom = null)
    {
        $this->setId($id);
        $this->setNom($nom);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): void
    {
        $this->nom = $nom;
    }
}