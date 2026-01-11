<?php
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
     * @brief Année du cours.
     */
    private int|null $annee;
    /**
     * @brief Parcour du cours.
     */
    private string|null $parcour;
    /**
     * @brief Semestre du cours.
     */
    private int|null $semestre;
    /**
     * @brief Type du cours.
     */
    private string|null $type;

    /**
     * @brief Constructeur de la classe Cours.
     * @param int|null $id Identifiant du cours.
     * @param string|null $libelle Libellé du cours.
     * @param int|null $annee Année du cours.
     * @param string|null $parcour Parcour du cours.
     * @param int|null $semestre Semestre du cours.
     * @param string|null $type Type du cours.
     */
    public function __construct(?int $id = null, ?string $libelle = null, ?int $annee = null, ?string $parcour = null, ?int $semestre = null, ?string $type = null)
    {
        $this->setId($id);
        $this->setLibelle($libelle);
        $this->setAnnee($annee);
        $this->setParcour($parcour);
        $this->setSemestre($semestre);
        $this->setType($type);
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

    /**
     * @brief Obtient l'année du cours.
     * @return int|null Année du cours.
     */
    public function getAnnee(): ?int
    {
        return $this->annee;
    }

    /**
     * @brief Définit l'année du cours.
     * @param int|null $annee Année du cours.
     */
    public function setAnnee(?int $annee): void
    {
        $this->annee = $annee;
    }

    /**
     * @brief Obtient le parcour du cours.
     * @return string|null Parcour du cours.
     */
    public function getParcour(): ?string
    {
        return $this->parcour;
    }

    /**
     * @brief Définit le parcour du cours.
     * @param string|null $parcour Parcour du cours.
     */
    public function setParcour(?string $parcour): void
    {
        $this->parcour = $parcour;
    }

    /**
     * @brief Obtient le semestre du cours.
     * @return int|null Semestre du cours.
     */
    public function getSemestre(): ?int
    {
        return $this->semestre;
    }

    /**
     * @brief Définit le semestre du cours.
     * @param int|null $semestre Semestre du cours.
     */
    public function setSemestre(?int $semestre): void
    {
        $this->semestre = $semestre;
    }

    /**
     * @brief Obtient le type du cours.
     * @return string|null Type du cours.
     */
    public function getType(): ?string
    {
        return $this->type;
    }
    
    /**
     * @brief Définit le type du cours.
     * @param string|null $type Type du cours.
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
    }
}
