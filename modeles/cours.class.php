<?php

// Definition de la classe Cours
/**
 * @file    cours.class.php
 * @brief   Définit la classe Cours représentant un cours.
 * @author  Rémi Bouillon
 * @date    19/06/2024
 */
class Cours
{
    /**
     * @brief Identifiant du cours.
     */
    private int|null $id;
    /**
     * @brief Libellé du cours.
     */ 
    private string|null $libelle;

    /**
     * @brief Constructeur de la classe Cours.
     * @param int|null $id Identifiant du cours.
     * @param string|null $libelle Libellé du cours.
     */
    public function __construct(?int $id = null, ?string $libelle = null)
    {
        $this->setId($id);
        $this->setLibelle($libelle);
    }

    /**
     * @brief Obtient l'identifiant du cours.
     * @return int|null Identifiant du cours.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @brief Définit l'identifiant du cours.
     * @param int|null $id Identifiant du cours.
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @brief Obtient le libellé du cours.
     * @return string|null Libellé du cours.
     */
    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    /**
     * @brief Définit le libellé du cours.
     * @param string|null $libelle Libellé du cours.
     */
    public function setLibelle(?string $libelle): void
    {
        $this->libelle = $libelle;
    }
}
