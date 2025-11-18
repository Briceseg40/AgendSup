CREATE TABLE IF NOT EXISTS `etudiant` (
  `id` int NOT NULL,
  `Nom` varchar(50) NOT NULL,
  `Prenom` varchar(50) NOT NULL,
  `role` varchar(50) DEFAULT NULL,
  `Année` int NOT NULL,
  `date_naissance` date NOT NULL,
  `mail` varchar(50) NOT NULL,
  `mdp` varchar(50) NOT NUL

  <?php


class Classe
{
    private int|null $id;
    private string|null $Nom;
    private string|null $Prenom;
    private string|null $role;
    private int|null $Annee;
    private string|null $DateNaissance;
    private string|null $Mail;
    private string|null $Mdp;

    public function __construct(?int $id = null, ?string $Nom = null, ?string $Prenom = null, ?string $role = null, ?int $Annee = null, ?string $DateNaissance = null, ?string $Mail = null, ?string $Mdp = null)
    {
        $this->setId($id);
        $this->setTd($Nom);
        $this->setTp($Prenom);
        $this->setTp($role);
        $this->setTp($Annee);
        $this->setTp($DateNaissance);
        $this->setTp($Mail);
        $this->setTp($Mdp);
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

    public function getDateNaissance(): ?string
    {
        return $this->DateNaissance;
    }

    public function setDateNaissance(?string $DateNaissance): void
    {
        $this->DateNaissance = $DateNaissance;
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

    public function setMdp(?int $Mdp): void
    {
        $this->Mdp = $Mdp;
    }
    
}
