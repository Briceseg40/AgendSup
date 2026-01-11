<?php
/**
 * @file    etudiant.class.php
 * @author  Guénolé Mourzelas et Baptiste Marsaa
 * @brief   Classe représentant un étudiant.
 * @details Cette classe encapsule les propriétés et méthodes
 * liées à un étudiant dans le système AgendSup.
 * @version 0.1
 * @date    19/12/2025
 */

class Etudiant
{
    /**
     * @brief Identifiant de l'étudiant.
     */
    private int|null $id;
    /**
     * @brief Nom de l'étudiant.
     */
    private string|null $Nom;
    /**
     * @brief Prénom de l'étudiant.
     */
    private string|null $Prenom;
    /**
     * @brief Rôle de l'étudiant.
     */
    private string|null $role;
    /**
     * @brief Année de l'étudiant.
     */
    private int|null $Annee;
    /**
     * @brief Email de l'étudiant.
     */
    private string|null $Mail;
    /**
     * @brief Mot de passe de l'étudiant.
     */
    private string|null $Mdp;
    /**
     * @brief Parcours de l'étudiant.
     */  
    private string|null $Parcour;
    /**
     * @brief Identifiant de la classe de l'étudiant.
     */
    private int|null $idClasse;

    /**
     * @brief Constructeur de la classe Etudiant.
     * @param int|null $id Identifiant de l'étudiant.
     * @param string|null $Nom Nom de l'étudiant.
     * @param string|null $Prenom Prénom de l'étudiant.
     * @param string|null $role Rôle de l'étudiant.
     * @param int|null $Annee Année de l'étudiant.
     * @param int|null $idClasse Identifiant de la classe de l'étudiant.
     * @param string|null $Mail Email de l'étudiant.
     * @param string|null $Mdp Mot de passe de l'étudiant.
     * @param string|null $Parcour Parcours de l'étudiant.
     */
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

    /**
     * @brief Obtient l'identifiant de l'étudiant.
     * @return int|null Identifiant de l'étudiant.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @brief Définit l'identifiant de l'étudiant.
     * @param int|null $id Identifiant de l'étudiant.
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @brief Obtient le nom de l'étudiant.
     * @return string|null Nom de l'étudiant.
     */
    public function getNom(): ?string
    {
        return $this->Nom;
    }

    /**
     * @brief Définit le nom de l'étudiant.
     * @param string|null $Nom Nom de l'étudiant.
     */
    public function setNom(?string $Nom): void
    {
        $this->Nom = $Nom;
    }

    /**
     * @brief Obtient le prénom de l'étudiant.
     * @return string|null Prénom de l'étudiant.
     */
    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    /**
     * @brief Définit le prénom de l'étudiant.
     * @param string|null $Prenom Prénom de l'étudiant.
     */
    public function setPrenom(?string $Prenom): void
    {
        $this->Prenom = $Prenom;
    }
    
    /**
     * @brief Obtient le rôle de l'étudiant.
     * @return string|null Rôle de l'étudiant.
     */
    public function getRole(): ?string
    {
        return $this->role;
    }

    /**
     * @brief Définit le rôle de l'étudiant.
     * @param string|null $role Rôle de l'étudiant.
     */
    public function setRole(?string $role): void
    {
        $this->role = $role;
    }

    /**
     * @brief Obtient l'année de l'étudiant.
     * @return int|null Année de l'étudiant.
     */
    public function getAnnee(): ?int
    {
        return $this->Annee;
    }

    /**
     * @brief Définit l'année de l'étudiant.
     * @param int|null $Annee Année de l'étudiant.
     */
    public function setAnnee(?int $Annee): void
    {
        $this->Annee = $Annee;
    }
    
    /**
     * @brief Obtient l'email de l'étudiant.
     * @return string|null Email de l'étudiant.
     */
    public function getMail(): ?string
    {
        return $this->Mail;
    }

    /**
     * @brief Définit l'email de l'étudiant.
     * @param string|null $Mail Email de l'étudiant.
     */
    public function setMail(?string $Mail): void
    {
        $this->Mail = $Mail;
    }

    /**
     * @brief Obtient le mot de passe de l'étudiant.
     * @return string|null Mot de passe de l'étudiant.
     */
    public function getMdp(): ?string
    {
        return $this->Mdp;
    }

    /**
     * @brief Définit le mot de passe de l'étudiant.
     * @param string|null $Mdp Mot de passe de l'étudiant.
     */
    public function setMdp(?string $Mdp): void
    {
        $this->Mdp = $Mdp;
    }

    /**
     * @brief Obtient l'identifiant de la classe de l'étudiant.
     * @return int|null Identifiant de la classe de l'étudiant.
     */
    public function getIdClasse(): ?int
    {
        return $this->idClasse;
    }

    /**
     * @brief Définit l'identifiant de la classe de l'étudiant.
     * @param int|null $idClasse Identifiant de la classe de l'étudiant.
     */
    public function setIdClasse(?int $idClasse): void
    {
        $this->idClasse = $idClasse;
    }

    /**
     * @brief Obtient le parcours de l'étudiant.
     * @return string|null Parcours de l'étudiant.
     */
    public function getParcour(): ?string
    {
        return $this->Parcour;
    }

    /**
     * @brief Définit le parcours de l'étudiant.
     * @param string|null $Parcour Parcours de l'étudiant.
     */
    public function setParcour(?string $Parcour): void
    {
        $this->Parcour = $Parcour;
    }

    /**
     * @brief Vérifie si l'email de l'étudiant existe déjà en base de données.
     * @return bool Vrai si l'email existe, sinon faux.
     */
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

    /**
     * @brief Vérifie la robustesse du mot de passe.
     * @param string $password Mot de passe à vérifier.
     * @return bool Vrai si le mot de passe est robuste, sinon faux.
     */
    public function estRobuste(string $password): bool
    {
        $regex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&.])[A-Za-z\d@$!%*?&.]{4,}$/';
        
        // La fonction preg_match retourne 1 si une correspondance est trouvée.
        return preg_match($regex, $password) === 1;
    }

    /**
     * @brief Inscrit l'étudiant en base de données.
     * @param EtudiantDAO $etudiantDAO Instance de EtudiantDAO pour l'insertion en base.
     * @throws Exception Si le mot de passe est faible ou si le compte existe déjà.
     */
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

    /**
     * @brief Authentifie l'étudiant en vérifiant l'email et le mot de passe.
     * @return bool Vrai si l'authentification réussie, sinon faux.
     */
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
                $this->id = $etudiantEnBase['id'];

                //Reinitialisation du mot de passe en clair pour ne pas conserver de données sensibles 
                $this->setMdp(null);

                return true; //Authentification réussie
            }
        }
        return false; //Authentification échouée
    }
}
