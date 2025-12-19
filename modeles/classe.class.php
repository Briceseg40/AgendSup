<?php
/**
 * @file    classe.class.php
 * @author  Rémi Bouillon
 * @brief   Classe représentant une classe de tavail.
 * @details Cette classe encapsule les propriétés et méthodes
 * liées à une classe de travail dans le système AgendSup.
 * @version 0.1
 * @date    19/12/2025
 */
class Classe
{
    /**
     * @brief Identifiant de la classe de travail.
     */
    private int|null $id;
    /**
     * @brief Numéro du TD.
     */
    private int|null $TD;
    /**
     * @brief Numéro du TP.
     */
    private int|null $TP;
    
    /**
     * @brief Constructeur de la classe Classe.
     * @param int|null $id Identifiant de la classe de travail.
     * @param int|null $TD Numéro du TD.
     * @param int|null $TP Numéro du TP.
     */
    public function __construct(?int $id = null, ?int $TD = null, ?int $TP = null)
    {
        $this->setId($id);
        $this->setTd($TD);
        $this->setTp($TP);

    }

    /**
     * @brief Obtient l'identifiant de la classe de travail.
     * @return int|null Identifiant de la classe de travail.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @brief Définit l'identifiant de la classe de travail.
     * @param int|null $id Identifiant de la classe de travail.
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @brief Obtient le numéro du TD.
     * @return int|null Numéro du TD.
     */
    public function getTd(): ?int
    {
        return $this->TD;
    }

    /**
     * @brief Définit le numéro du TD.
     * @param int|null $TD Numéro du TD.
     */
    public function setTd(?string $TD): void
    {
        $this->TD = $TD;
    }

    /**
     * @brief Obtient le numéro du TP.
     * @return int|null Numéro du TP.
     */
    public function getTp(): ?int
    {
        return $this->TP;
    }

    /**
     * @brief Définit le numéro du TP.
     * @param int|null $TP Numéro du TP.
     */
    public function setTp(?string $TP): void
    {
        $this->TP = $TP;
    }
    
}
