<?php

class Etudiant
{
    private int|null $id;
    private string|null $Nom;
    private string|null $Prenom;
    private string|null $role;
    private int|null $Annee;
    private string|null $Mail;
    private string|null $Mdp;   
    private string|null $Parcour;
    private int|null $idClasse;

    public function __construct(?int $id = null, ?string $Nom = null, ?string $Prenom = null, ?string $role = null, ?int $Annee = null, ?int $idClasse = null, ?string $Mail = null, ?string $Mdp = null, ?string $Parcour = null)
    {
        $this->setId($id);
        $this->setNom($Nom);
        $this->setPrenom($Prenom);
        $this->setRole($role);
        $this->setAnnee($Annee);
        $this->setIdClasse($idClasse);
        $this->setMail($Mail);
        $this->setMdp($Mdp);
        $this->setParcour($Parcour);
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

    public function getParcour(): ?string
    {
        return $this->Parcour;
    }

    public function setParcour(?string $Parcour): void
    {
        $this->Parcour = $Parcour;
    }

    public function mailExiste(): bool
    {
        //Connexion à la base de données
        $pdo = Bd::getInstance()->getConnection();

        //Préparation de la requête pour vérifier si l'email existe
        $requete = $pdo->prepare("SELECT COUNT(*) FROM etudiant WHERE mail = :mail");

        //Execution de la requete avec l'email recupere au niveau du formulaire
        $requete->execute([':mail' => $this->getMail()]);

        //Retourne vrai si l'email existe, sinon faux
        return $requete->fetchColumn() > 0;
    }

    public function estRobuste(string $password): bool
    {
        $regex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&.])[A-Za-z\d@$!%*?&.]{4,}$/';
        
        // La fonction preg_match retourne 1 si une correspondance est trouvée.
        return preg_match($regex, $password) === 1;
    }

    public function inscription(EtudiantDAO $etudiantDAO): void 
    {
        //Verification de la robustesse du mot de passe
        if (!$this->estRobuste($this->getMdp())) 
        {
            throw new Exception("Mot de passe faible");
        }

        //Verifie si l'email existe déjà
        if ($this->mailExiste()) 
        {
            throw new Exception("Compte existant");
        }

        //Obtention de l'instance PDO via la classe BD
        $pdo = Bd::getInstance()->getConnection();

        //Appel de la méthode ajouter de EtudiantDAO pour insérer l'étudiant en base
        $etudiantDAO->ajouter($this);
    }

    public function authentification(): bool 
    {
        //Connexion à la base de données
        $pdo = Bd::getInstance()->getConnection();

        //Recherche de l'etudiant correspondant à l'email fourni
        $requete = $pdo->prepare("SELECT * FROM etudiant WHERE mail = :mail");

        //execution de la requete avec l'email de l'etudiant
        $requete->execute([':mail' => $this->getMail()]);

        //Recupération des informations de l'etudiant en base 
        $etudiantEnBase = $requete->fetch();
        
        //Vérifie si l'etudiant en base existe
        if ($etudiantEnBase)
        {
            //Utilise password_verify pour comparer le mot de passe fourni avec le mot de passe haché en base
            if (password_verify($this->getMdp(), $etudiantEnBase['mdp'])) 
            {
                $this->identifiant = $etudiantEnBase['id'];

                //Reinitialisation du mot de passe en clair pour ne pas conserver de données sensibles 
                $this->setMdp(null);

                return true; //Authentification réussie
            }
        }
        return false; //Authentification échouée
    }
}
