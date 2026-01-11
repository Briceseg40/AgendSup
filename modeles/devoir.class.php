<?php
/**
 * @file devoir.class.php
 * @brief Définit la classe Devoir représentant un devoir.
 * @author Rémi Bouillon
 * @date 19/06/2024
 */

class Devoir {
    //Attributs
    /**
     * @brief Identifiant du devoir.
     */
    private int|null $id;
    /**
     * @brief Libellé du devoir.
     */
    private string|null $libelle;
    /**
     * @brief Date de début du devoir.
     */
    private string|null $date_deb;
    /**
     * @brief Date de fin du devoir.
     */
    private string|null $date_fin;
    /**
     * @brief Heure de début du devoir.
     */
    private string|null $heure_deb;
    /**
     * @brief Heure de fin du devoir.
     */
    private string|null $heure_fin;
    /**
     * @brief Contenu du devoir.
     */
    private string|null $contenu;
    /**
     * @brief Couleur associée au devoir.
     */
    private string|null $couleur;
    /**
     * @brief Identifiant du cours associé au devoir.
     */
    private int|null $idCours;
    /**
     * @brief Identifiant de la classe associée au devoir.
     */
    private int|null $idClasse;
    /**
     * @brief Identifiant de l'étudiant associé au devoir.
     */
    private int|null $idEtudiant;

    //Constructeur
    /**
     * @brief Constructeur de la classe Devoir.
     * @param int|null $id Identifiant du devoir.
     * @param string|null $libelle Libellé du devoir.
     * @param string|null $date_deb Date de début du devoir.
     * @param string|null $date_fin Date de fin du devoir.
     * @param string|null $heure_deb Heure de début du devoir.
     * @param string|null $heure_fin Heure de fin du devoir.
     * @param string|null $contenu Contenu du devoir.
     * @param string|null $couleur Couleur associée au devoir.
     * @param int|null $idCours Identifiant du cours associé au devoir.
     * @param int|null $idClasse Identifiant de la classe associée au devoir.
     * @param int|null $idEtudiant Identifiant de l'étudiant associé au devoir.
     */
    public function __construct(?int $id = null, ?string $libelle = null, ?string $date_deb = null,?string $date_fin = null,?string $heure_deb = null,?string $heure_fin = null, ?string $contenu = null, ?string $couleur = null, ?int $idCours = null, ?int $idClasse = null, ?int $idEtudiant = null) {
        $this->id = $id;
        $this->libelle = $libelle;
        $this->date_deb = $date_deb;
        $this->date_fin = $date_fin;
        $this->heure_deb = $heure_deb;
        $this->heure_fin = $heure_fin;
        $this->contenu = $contenu;  
        $this->couleur = $couleur;
        $this->idCours = $idCours;
        $this->idClasse = $idClasse;
        $this->idEtudiant = $idEtudiant;
    }

    //Getters et Setters
    /**
     * @brief Obtient l'identifiant du devoir.
     * @return int|null Identifiant du devoir.
     */ 
    public function getId(): ?int 
    {
        return $this->id;
    }
    /**
     * @brief Définit l'identifiant du devoir.
     * @param int $id Identifiant du devoir.
     */
    public function setId(int $id): void 
    {
        $this->id = $id;
    }
    /**
     * @brief Obtient le libellé du devoir.
     * @return string|null Libellé du devoir.
     */
    public function getLibelle(): ?string
    {
        return $this->libelle;
    }
    /**
     * @brief Définit le libellé du devoir.
     * @param string $libelle Libellé du devoir.
     */
    public function setLibelle(string $libelle): void
    {
        $this->libelle = $libelle;
    }
    /**
     * @brief Obtient la date de début du devoir.
     * @return string|null Date de début du devoir.
     */
    public function getDateDeb(): string
    {
        return $this->date_deb;
    }
    /**
     * @brief Définit la date de début du devoir.
     * @param string $date_deb Date de début du devoir.
     */
    public function setDateDeb(string $date_deb): void
    {
        $this->date_deb = $date_deb;
    }
    /**
     * @brief Obtient la date de fin du devoir.
     * @return string|null Date de fin du devoir.
     */
    public function getDatefin(): string
    {
        return $this->date_fin;
    }
    /**
     * @brief Définit la date de fin du devoir.
     * @param string $date_fin Date de fin du devoir.
     */
    public function setDateFin(string $date_fin): void
    {
        $this->date_fin = $date_fin;
    }

    /**
     * @brief Obtient l'heure de début du devoir.
     * @return string|null Heure de début du devoir.
     */
    public function getHeureDeb(): string
    {
        return $this->heure_deb;
    }

    /**
     * @brief Définit l'heure de début du devoir.
     * @param string $heure_deb Heure de début du devoir.
     */
    public function setHeureDeb(string $heure_deb): void
    {
        $this->heure_deb = $heure_deb;
    }

    /**
     * @brief Obtient l'heure de fin du devoir.
     * @return string|null Heure de fin du devoir.
     */
    public function getHeureFin(): string
    {
        return $this->heure_fin;
    }

    /**
     * @brief Définit l'heure de fin du devoir.
     * @param string $heure_fin Heure de fin du devoir.
     */
    public function setHeureFin(string $heure_fin): void
    {
        $this->heure_fin = $heure_fin;
    }

    /**
     * @brief Obtient le contenu du devoir.
     * @return string|null Contenu du devoir.
     */
    public function getContenu(): string
    {
        return $this->contenu;
    }

    /**
     * @brief Définit le contenu du devoir.
     * @param string $contenu Contenu du devoir.
     */
    public function setContenu(string $contenu): void
    {
        $this->contenu = $contenu;
    }

    /**
     * @brief Définit la couleur associée au devoir.
     * @param string $couleur Couleur associée au devoir.
     */
    public function setCouleur(string $couleur): void
    {
        $this->couleur = $couleur;
    }

    /**
     * @brief Obtient la couleur associée au devoir.
     * @return string|null Couleur associée au devoir.
     */
    public function getCouleur(): string
    {
        return $this->couleur;
    }

    /**
     * @brief Obtient l'identifiant du cours associé au devoir.
     * @return int|null Identifiant du cours associé au devoir.
     */
    public function getIdCours(): int
    {
        return $this->idCours;
    }

    /**
     * @brief Définit l'identifiant du cours associé au devoir.
     * @param int $idCours Identifiant du cours associé au devoir.
     */
    public function setIdCours(int $idCours): void
    {
        $this->idCours = $idCours;
    }

    /**
     * @brief Obtient l'identifiant de la classe associée au devoir.
     * @return int|null Identifiant de la classe associée au devoir.
     */
    public function getIdClasse(): int
    {
        return $this->idClasse;
    }

    /**
     * @brief Définit l'identifiant de la classe associée au devoir.
     * @param int $idClasse Identifiant de la classe associée au devoir.
     */
    public function setIdClasse(int $idClasse): void
    {
        $this->idClasse = $idClasse;
    }

    /**
     * @brief Obtient l'identifiant de l'étudiant associé au devoir.
     * @return int|null Identifiant de l'étudiant associé au devoir.
     */
    public function getIdEtudiant(): int
    {
        return $this->idEtudiant;
    }

    /**
     * @brief Définit l'identifiant de l'étudiant associé au devoir.
     * @param int $idEtudiant Identifiant de l'étudiant associé au devoir.
     */
    public function setIdEtudiant(int $idEtudiant): void
    {
        $this->idEtudiant = $idEtudiant;
    }

    //Méthode usuelles
    /**
     * @brief Représentation sous forme de chaîne de caractères du devoir.
     * @return string Représentation du devoir.
     */
    public function __toString(): string {
        return "Devoir [id={$this->id}, libelle={$this->libelle}, date_deb={$this->date_deb}, date_fin={$this->date_fin},heure_deb={$this->heure_deb},date_fin={$this->date_fin},contenu={$this->contenu}, couleur={$this->couleur}, idCours={$this->idCours}, idClasse={$this->idClasse}]";
    }
}
