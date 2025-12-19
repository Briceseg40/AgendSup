<?php
/**
 * @file    agenda.class.php
 * @author  Rémi Bouillon
 * @brief   Classe représentant un agenda.
 * @details Cette classe encapsule les propriétés et méthodes
 * liées à un agenda dans le système AgendSup.
 * @version 0.1
 * @date    19/12/2025
 */
class Agenda
{   
    /**
     * @brief Identifiant de l'agenda.
     */
    private int|null $id;
    /**
     * @brief Mois de l'agenda.
     */
    private string|null $mois;
    /**
     * @brief Jour de l'agenda.
     */
    private string|null $jour;
    
    /**
     * @brief Constructeur de la classe Agenda.
     * @param int|null $id Identifiant de l'agenda.
     * @param string|null $mois Mois de l'agenda.
     * @param string|null $jour Jour de l'agenda.
     */
    public function __construct(?int $id = null, ?string $mois = null, ?string $jour = null)
    {
        $this->setId($id);
        $this->setMois($mois);
        $this->setJour($jour);
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
     * @brief Obtient le mois de l'agenda.
     * @return string|null Mois de l'agenda.
     */
    public function getMois(): ?string
    {
        return $this->mois;
    }

    /**
     * @brief Définit le mois de l'agenda.
     * @param string|null $mois Mois de l'agenda.
     */
    public function setMois(?string $mois): void
    {
        $this->mois = $mois;
    }

    /**
     * @brief Obtient le jour de l'agenda.
     * @return string|null Jour de l'agenda.
     */
    public function getJour(): ?string
    {
        return $this->jour;
    }

    /**
     * @brief Définit le jour de l'agenda.
     * @param string|null $jour Jour de l'agenda.
     */
    public function setJour(?string $jour): void
    {
        $this->jour = $jour;
    }
}