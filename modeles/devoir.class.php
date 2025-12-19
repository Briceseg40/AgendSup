<?php
/**
 * @file devoir.class.php
 * @brief Définit la classe Devoir représentant un devoir.
 * @author Rémi Bouillon
 * @date 19/06/2024
 */
class Devoir {
    //Attributs
    /** @var int $id Identifiant du devoir.
     */
    private int $id;
    /** @var string $libelle Libellé du devoir.
     */
    private string $libelle;
    /** @var string $date_a_realiser Date à réaliser du devoir.
     */
    private string $date_a_realiser;
    /** @var string $contenu Contenu du devoir.
     */
    private string $contenu;
    /** @var int $idCours Identifiant du cours associé au devoir.
     */
    private int $idCours;

    //Constructeur
    /**
     * @brief Constructeur de la classe Devoir.
     * @param int|null $id Identifiant du devoir.
     * @param string|null $libelle Libellé du devoir.
     * @param string|null $date_a_realiser Date à réaliser du devoir.
     * @param string|null $contenu Contenu du devoir.
     * @param int|null $idCours Identifiant du cours associé au devoir.
     */
    public function __construct(?int $id = null, ?string $libelle = null, ?string $date_a_realiser = null, ?string $contenu = null, ?int $idCours = null) {
        $this->id = $id;
        $this->libelle = $libelle;
        $this->date_a_realiser = $date_a_realiser;
        $this->contenu = $contenu;
        $this->idCours = $idCours;
    }

    //Getters et Setters
    /** @return int|null Identifiant du devoir.
     */
    public function getId(): ?int 
    {
        return $this->id;
    }

    /** @param int $id Identifiant du devoir.
     */
    public function setId(int $id): void 
    {
        $this->id = $id;
    }

    /** @return string|null Libellé du devoir.
     */
    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    /** @param string $libelle Libellé du devoir.
     */
    public function setLibelle(string $libelle): void
    {
        $this->libelle = $libelle;
    }

    /** @return string|null Date à réaliser du devoir.
     */
    public function getDateARealiser(): string
    {
        return $this->date_a_realiser;
    }

    /** @param string $date_a_realiser Date à réaliser du devoir.
     */
    public function setDateARealiser(string $date_a_realiser): void
    {
        $this->date_a_realiser = $date_a_realiser;
    }

    /** @return string|null Contenu du devoir.
     */
    public function getContenu(): string
    {
        return $this->contenu;
    }


    /** @param string $contenu Contenu du devoir.
     */
    public function setContenu(string $contenu): void
    {
        $this->contenu = $contenu;
    }

    /** @return int|null Identifiant du cours associé au devoir.
     */
    public function getIdCours(): int
    {
        return $this->idCours;
    }

    /** @param int $idCours Identifiant du cours associé au devoir.
     */
    public function setIdCours(int $idCours): void
    {
        $this->idCours = $idCours;
    }

    //Méthode usuelles
    /** @return string Représentation sous forme de chaîne de caractères du devoir.
     */
    public function __toString(): string {
        return "Devoir [id={$this->id}, libelle={$this->libelle}, date_a_realiser={$this->date_a_realiser}, contenu={$this->contenu}, idCours={$this->idCours}]";
    }
}
