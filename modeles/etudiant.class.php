<?php
/**
 * @file    etudiant.class.php
 * @author  Guénolé Mourzelas
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
     * @brief Année scolaire de l'étudiant (1er/ 2ème/3ème).
     */
    private int|null $Annee;
      /**
     * @brief Date de naisssance de l'étudiant.
     */
    private string|null $DateNaissance;
    /**
    * @brief Adresse mail de l'étudiant.
    */
    private string|null $Mail;
    /**
     * @brief Mot de passe de l'étudiant.
     */
    private string|null $Mdp;

    /**
     * @brief Constructeur de la classe Etudiant.
     * @param int|null $id Identifiant de l'étudiant.
     * @param string|null $Nom Nom de l'étudiant.
     * @param string|null $Prenom Prénom de l'étudiant.
     * @param string|null $role Rôle de l'étudiant.
     * @param int|null $Annee Année scolaire de l'étudiant.
     * @param string|null $DateNaissance Date de naissance de l'étudiant.
     * @param string|null $Mail Adresse mail de l'étudiant.
     * @param string|null $Mdp Mot de passe de l'étudiant.
     */
    public function __construct(?int $id = null, ?string $Nom = null, ?string $Prenom = null, ?string $role = null, ?int $Annee = null, ?string $DateNaissance = null, ?string $Mail = null, ?string $Mdp = null)
    {
        $this->setId($id);
        $this->setNom($Nom);
        $this->setPrenom($Prenom);
        $this->setRole($role);
        $this->setAnnee($Annee);
        $this->setDateNaissance($DateNaissance);
        $this->setMail($Mail);
        $this->setMdp($Mdp);
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
     * @brief Obtient l'année scolaire de l'étudiant.
     * @return int|null Année scolaire de l'étudiant.
     */
    public function getAnnee(): ?int
    {
        return $this->Annee;
    }

    /**
     * @brief Définit l'année scolaire de l'étudiant.
     * @param int|null $Annee Année scolaire de l'étudiant.
     */
    public function setAnnee(?int $Annee): void
    {
        $this->Annee = $Annee;
    }

    /**
     * @brief Obtient la date de naissance de l'étudiant.
     * @return string|null Date de naissance de l'étudiant.
     */
    public function getDateNaissance(): ?string
    {
        return $this->DateNaissance;
    }

    /**
     * @brief Définit la date de naissance de l'étudiant.
     * @param string|null $DateNaissance Date de naissance de l'étudiant.
     */
    public function setDateNaissance(?string $DateNaissance): void
    {
        $this->DateNaissance = $DateNaissance;
    }
    
    /**
     * @brief Obtient l'adresse mail de l'étudiant.
     * @return string|null Adresse mail de l'étudiant.
     */
    public function getMail(): ?string
    {
        return $this->Mail;
    }

    /**
     * @brief Définit l'adresse mail de l'étudiant.
     * @param string|null $Mail Adresse mail de l'étudiant.
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

}
