<?php

#[\AllowDynamicProperties]
class Etudiant
{
    private int|null $id;
    private string|null $Nom;
    private string|null $Prenom;
    private string|null $role;
    private int|null $Annee;
    private int|null $idClasse;
    private string|null $Mail;
    private string|null $Mdp;   

    public function __construct(?int $id = null, ?string $Nom = null, ?string $Prenom = null, ?string $role = null, ?int $Annee = null, ?int $idClasse = null, ?string $Mail = null, ?string $Mdp = null)
    {
        $this->setId($id);
        $this->setNom($Nom);
        $this->setPrenom($Prenom);
        $this->setRole($role);
        $this->setAnnee($Annee);
        $this->setIdClasse($idClasse);
        $this->setMail($Mail);
        $this->setMdp($Mdp);
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
        return $this->Nom;
    }

    public function setNom(?string $Nom): void
    {
        $this->Nom = $Nom;
    }

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(?string $Prenom): void
    {
        $this->Prenom = $Prenom;
    }
    
    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(?string $role): void
    {
        $this->role = $role;
    }

    public function getAnnee(): ?int
    {
        return $this->Annee;
    }

    public function setAnnee(?int $Annee): void
    {
        $this->Annee = $Annee;
    }
    
    public function getMail(): ?string
    {
        return $this->Mail;
    }

    public function setMail(?string $Mail): void
    {
        $this->Mail = $Mail;
    }

    public function getMdp(): ?string
    {
        return $this->Mdp;
    }

    public function setMdp(?string $Mdp): void
    {
        $this->Mdp = $Mdp;
    }

    public function getIdClasse(): ?int
    {
        return $this->idClasse;
    }

    public function setIdClasse(?int $idClasse): void
    {
        $this->idClasse = $idClasse;
    }

}
