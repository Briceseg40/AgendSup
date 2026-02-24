<?php

class CoursPrevue
{
    /**
     * @brief Identifiant du coursPrevue.
     */
    private int|null $id;

    /**
     * @brief Date de début du coursPrevue.
     */
    private string|null $date_deb;

    /**
     * @brief Date de fin du coursPrevue.
     */
    private string|null $date_fin;

    /**
     * @brief Libellé du coursPrevue.
     */
    private string|null $libelle;

    /**
     * @brief Description détaillée du coursPrevue.
     */
    private string|null $description;

    /**
     * @brief Constructeur de la classe coursPrevue.
     * @param int|null $id
     * @param string|null $date_deb
     * @param string|null $date_fin
     * @param string|null $libelle
     * @param string|null $description
     */
    public function __construct(
        ?int $id = null,
        ?string $date_deb = null,
        ?string $date_fin = null,
        ?string $libelle = null,
        ?string $description = null
    ) {
        $this->setId($id);
        $this->setDateDeb($date_deb);
        $this->setDateFin($date_fin);
        $this->setLibelle($libelle);
        $this->setDescription($description);
    }

    // --- GETTERS & SETTERS ---

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getDateDeb(): ?string
    {
        return $this->date_deb;
    }

    public function setDateDeb(?string $date_deb): void
    {
        $this->date_deb = $date_deb;
    }

    public function getDateFin(): ?string
    {
        return $this->date_fin;
    }

    public function setDateFin(?string $date_fin): void
    {
        $this->date_fin = $date_fin;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle): void
    {
        $this->libelle = $libelle;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }
}