<?php
/**
 * @file    chat.class.php
 * @author  Rémi Montignac
 * @brief   Classe représentant un chat.
 * @details Cette classe encapsule les propriétés et méthodes
 * liées à un chat dans le système AgendSup.
 * @version 0.1
 * @date    19/12/2025
 */
class Chat
{   
    /**
     * @brief Identifiant du chat.
     */
    private int|null $id;
    /**
     * @brief Nom du chat.
     */
    private string|null $nom;

    /**
     * @brief Constructeur de la classe Chat.
     * @param int|null $id Identifiant du chat.
     * @param string|null $nom Nom du chat.
     */
    public function __construct(?int $id = null, ?string $nom = null)
    {
        $this->setId($id);
        $this->setNom($nom);
    }

    /**
     * @brief Obtient l'identifiant du chat.
     * @return int|null Identifiant du chat.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @brief Définit l'identifiant du chat.
     * @param int|null $id Identifiant du chat.
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @brief Obtient le nom du chat.
     * @return string|null Nom du chat.
     */
    public function getNom(): ?string
    {
        return $this->nom;
    }

    /**
     * @brief Définit le nom du chat.
     * @param string|null $nom Nom du chat.
     */
    public function setNom(?string $nom): void
    {
        $this->nom = $nom;
    }
}