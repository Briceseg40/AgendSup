<?php

/**
 * @file classe.class.php
 * @brief Ce fichier contient la classe Classe.

 */
class Classe
{
    private int|null $id;
    private int|null $TD;
    private int|null $TP;
 
    public function __construct(?int $id = null, ?int $TD = null, ?int $TP = null)
    {
        $this->setId($id);
        $this->setTd($TD);
        $this->setTp($TD);

    }

    /**
     * @brief Récupère l'identifiant de la classe.
     *
     * @return int|null Identifiant de la classe.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @brief Définit l'identifiant de la classe.
     *
     * @param int|null $id Identifiant de la classe.
     * @return void
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @brief Récupère le Numéro du td.
     *
     * @return int|null Numéro du td.
     */
    public function getTd(): ?int
    {
        return $this->TD;
    }

    /**
     * @brief Définit le Numéro du td.
     *
     * @param string|null $TD Numéro du td.
     * @return void
     */
    public function setTd(?string $TD): void
    {
        $this->TD = $TD;
    }

        /**
     * @brief Récupère le Numéro du tp.
     *
     * @return int|null Numéro du tp.
     */
    public function getTp(): ?int
    {
        return $this->TP;
    }

    /**
     * @brief Définit le Numéro du tp.
     *
     * @param string|null $tp Numéro du tp.
     * @return void
     */
    public function setTp(?string $TP): void
    {
        $this->TP = $TP;
    }
    
}
