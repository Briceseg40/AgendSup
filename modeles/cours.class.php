<?php

/**
 * @file categorie.class.php
 * @brief Ce fichier contient la classe Categorie pour représenter une catégorie de Recette.
 */

/**
 * @brief Classe Categorie pour représenter une catégorie de Recette.
 *
 * @details Cette classe permet de représenter une catégorie de Recette (entrée, plat, dessert...).
 */
class Cours
{
    /**
     * @brief Identifiant du cours.
     */
    private int|null $id;

    /**
     * @brief libelle d'un cours.
     */    
    private string|null $libelle;
    /**
     * @brief Constructeur de la classe Categorie.
     *
     * @param int|null $id Identifiant de la catégorie.
     * @param string|null $nom Nom de la catégorie.
     * @param string|null $image Nom du fichier image associé à la catégorie.
     */
    public function __construct(?int $id = null, ?string $libelle = null, ?string $dte_cours = null, ?string $horaire_cours = null)
    {
        $this->setId($id);
        $this->setLibelle($libelle);
    }

    /**
     * @brief Récupère l'identifiant de la catégorie.
     *
     * @return int|null Identifiant de la catégorie.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @brief Définit l'identifiant de la catégorie.
     *
     * @param int|null $id Identifiant de la catégorie.
     * @return void
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @brief Récupère le nom de la catégorie.
     *
     * @return string|null Nom de la catégorie.
     */
    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    /**
     * @brief Définit le nom de la catégorie.
     *
     * @param string|null $nom Nom de la catégorie.
     * @return void
     */
    public function setLibelle(?string $libelle): void
    {
        $this->libelle = $libelle;
    }
}
