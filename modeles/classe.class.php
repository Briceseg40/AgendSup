<?php
/**
 * @file    classe.class.php
 * @author  Rémi Bouillon et Brice Seguret
 * @brief   Classe représentant une classe de tavail.
 * @details Cette classe encapsule les propriétés et méthodes
 * liées à une classe de travail dans le système AgendSup.
 * @version 0.1
 * @date    19/12/2025
 */
class Classe
{
    /**
     * @brief Identifiant de la classe.
     */
    private ?int $id;
    /**
     * @brief Image associée à la classe.
     */
    private ?string $img;
    /**
     * @brief Titre de la classe.
     */
    private ?string $titre;
    /**
     * @brief Description de la classe.
     */
    private ?string $description;
    /**
     * @brief Numéro de TD dans la classe.
     */
    private ?int $TD;
    /**
     * @brief Numéro de TP dans la classe.
     */
    private ?int $TP;
    /**
     * @brief Identifiant de l'étudiant associé à la classe.
     */
    private ?int $idEtudiant;
    /**
     * @brief Année de la classe.
     */
    private ?int $annee;
    /**
     * @brief Code de la classe.
     */
    private ?string $code;

    /**
     * @brief Constructeur de la classe Classe.
     * @param int|null $id Identifiant de la classe.
     * @param string|null $img Image associée à la classe.
     * @param string|null $titre Titre de la classe.
     * @param string|null $description Description de la classe.
     * @param int|null $TD Numéro du TD.
     * @param int|null $TP Numéro du TP.
     * @param int|null $idEtudiant Identifiant de l'étudiant associé à la classe.
     * @param int|null $annee Année de la classe.
     * @param string|null $code Code de la classe.
     */
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

    //Getters et Setters
    /**
     * @brief Obtient l'identifiant de la classe.
     * @return int|null Identifiant de la classe.
     */
    public function getId(): ?int
    {
        return $this->id;
    }
    /**
     * @brief Définit l'identifiant de la classe.
     * @param int|null $id Identifiant de la classe.
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }
    /**
     * @brief Obtient l'image associée à la classe.
     * @return string|null Image associée à la classe.
     */
    public function getImage(): ?string
    {
        return $this->img;
    }
    /**
     * @brief Définit l'image associée à la classe.
     * @param string|null $img Image associée à la classe.
     */
    public function setImage(?string $img): void
    {
        $this->img = $img;
    }
    /**
     * @brief Obtient le titre de la classe.
     * @return string|null Titre de la classe.
     */
    public function getTitre(): ?string
    {
        return $this->titre;
    }
    /**
     * @brief Définit le titre de la classe.
     * @param string|null $titre Titre de la classe.
     */
    public function setTitre(?string $titre): void
    {
        $this->titre = $titre;
    }
    /**
     * @brief Obtient la description de la classe.
     * @return string|null Description de la classe.
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }
    /**
     * @brief Définit la description de la classe.
     * @param string|null $description Description de la classe.
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }
    /**
     * @brief Obtient le numéro de TD dans la classe.
     * @return int|null Numéro de TD dans la classe.
     */
    public function getTD(): ?int
    {
        return $this->TD;
    }
    /**
     * @brief Définit le numéro de TD dans la classe.
     * @param int|null $TD Numéro de TD dans la classe.
     */
    public function setTD(?int $TD): void
    {
        $this->TD = $TD;
    }
    /**
     * @brief Obtient le numéro de TP dans la classe.
     * @return int|null Numéro de TP dans la classe.
     */
    public function getTP(): ?int
    {
        return $this->TP;
    }
    /**
     * @brief Définit le numéro de TP dans la classe.
     * @param int|null $TP Numéro de TP dans la classe.
     */
    public function setTP(?int $TP): void
    {
        $this->TP = $TP;
    }
    /**
     * @brief Obtient l'identifiant de l'étudiant associé à la classe.
     * @return int|null Identifiant de l'étudiant associé à la classe.
     */
    public function getIdEtudiant(): ?int
    {
        return $this->idEtudiant;
    }
    /**
     * @brief Définit l'identifiant de l'étudiant associé à la classe.
     * @param int|null $idEtudiant Identifiant de l'étudiant associé à la classe.
     */
    public function setIdEtudiant(?int $idEtudiant): void
    {
        $this->idEtudiant = $idEtudiant;
    }
    /**
     * @brief Obtient l'année de la classe.
     * @return int|null Année de la classe.
     */
    public function getAnnee(): ?int
    {
        return $this->annee;
    }
    /**
     * @brief Définit l'année de la classe.
     * @param int|null $annee Année de la classe.
     */
    public function setAnnee(?int $annee): void
    {
        $this->annee = $annee;
    }
    /**
     * @brief Obtient le code de la classe.
     * @return string|null Code de la classe.
     */
    public function getCode(): ?string
    {
        return $this->code;
    }
    /**
     * @brief Définit le code de la classe.
     * @param string|null $code Code de la classe.
     */
    public function setCode(?string $code): void
    {
        $this->code = $code;
    }
}
