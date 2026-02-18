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
class classeVirtuel
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

    private ?int $idCreateur;

    private ?int $idClasse;

    public ?string $nomCreateur = null;
    public ?string $prenomCreateur = null;
    
    /**
     * @brief Code de la classe.
     */
    private ?string $code;

    /**
     * @brief Constructeur de la classe ClasseVirtuel.
     * @param int|null $id Identifiant de la classeVirtuel.
     * @param string|null $img Image associée à la classeVirtuel.
     * @param string|null $titre Titre de la classeVirtuel.
     * @param string|null $description Description de la classeVirtuel.
     * @param int|null $idCreateur Identifiant de l'étudiant associé à la classeVirtuel.
     * @param int|null $idClasse Identifiant de la classe associé à la classeVirtuel.
     * @param string|null $code Code de la classe.
     */
    public function __construct(?int $id = null, ?string $img = null, ?string $titre = null, ?string $description = null,?int $idClasse=null,?int $idCreateur=null, ?string $code = null)
    {
        $this->id = $id;
        $this->img = $img;
        $this->titre = $titre;
        $this->description = $description;
        $this->idClasse = $idClasse;
        $this->idCreateur = $idCreateur;
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


    public function getIdClasse(): ?int
    {
        return $this->idClasse;
    }

    public function setIdClasse(?int $idClasse): void
    {
        $this->idClasse = $idClasse;
    }

    public function getIdCreateur(): ?int
    {
        return $this->idCreateur;
    }

    public function setIdCreateur(?int $idCreateur): void
    {
        $this->idCreateur = $idCreateur;
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
