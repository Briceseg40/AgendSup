<?php
/**
 * @file controller.class.php
 * @brief Classe de base pour les contrôleurs.
 *
 * Cette classe fournit les fonctionnalités de base pour les contrôleurs,
 * y compris la gestion de la connexion à la base de données et l'intégration
 * avec le moteur de templates Twig.
 */
class Controller
{
    //Attributs
    //PDO instance pour la connexion à la base de données
    private PDO $pdo;
    //Twig loader pour charger les templates
    private \Twig\Loader\FilesystemLoader $loader;
    //Twig environment pour rendre les templates
    private \Twig\Environment $twig;
    //Tableaux pour stocker les données GET et POST
    private ?array $get = null;
    private ?array $post = null;

    //Constructeur
    /**
     * @brief Constructeur de la classe Controller.
     *
     * Initialise la connexion à la base de données et configure Twig.
     *
     * @param \Twig\Loader\FilesystemLoader $loader Chargeur de templates Twig.
     * @param \Twig\Environment $twig Environnement Twig.
     */
    public function __construct(\Twig\Loader\FilesystemLoader $loader, \Twig\Environment $twig)
    {
        $db = Bd::getInstance();
        $this->pdo = $db->getConnection();

        $this->loader = $loader;
        $this->twig = $twig;

        if (isset($_GET) && !empty($_GET))
        {
            $this->get = $_GET;
        }

        if (isset($_POST) && !empty($_POST))
        {
            $this->post = $_POST;
        }
    }

    //Methode call
    /**
     * @brief Appelle une méthode du contrôleur.
     *
     * Vérifie si la méthode existe et l'appelle.
     *
     * @param string $methode Nom de la méthode à appeler.
     * @return mixed Résultat de l'appel de la méthode.
     * @throws Exception Si la méthode n'existe pas.
     */
    public function call(string $methode): mixed
    {
        //teste si la methode existe
        if (!method_exists($this, $methode))
        {
            throw new Exception("La methode $methode n'existe pas dans le controleur " . get_class($this));
            // throw new Exception("La methode $methode n'existe pas dans le controleur __CLASS__");
        }

        return $this->$methode();
    }

    //Getters et Setters
    /**
     * @brief Obtient l'instance PDO.
     *
     * @return PDO|null Instance PDO ou null si non initialisée.
     */
    public function getPdo(): ?PDO
    {
        return $this->pdo;
    }

    /**
     * @brief Définit l'instance PDO.
     *
     * @param PDO $pdo Instance PDO à définir.
     */
    public function setPdo(PDO $pdo): void
    {
        $this->pdo = $pdo;
    }

    /**
     * @brief Obtient le chargeur de templates Twig.
     *
     * @return \Twig\Loader\FilesystemLoader Chargeur de templates Twig.
     */
    public function getLoader(): \Twig\Loader\FilesystemLoader
    {
        return $this->loader;
    }

    /**
     * @brief Définit le chargeur de templates Twig.
     *
     * @param \Twig\Loader\FilesystemLoader $loader Chargeur de templates Twig à définir.
     */
    public function setLoader(\Twig\Loader\FilesystemLoader $loader): void
    {
        $this->loader = $loader;
    }

    /**
     * @brief Obtient l'environnement Twig.
     *
     * @return \Twig\Environment Environnement Twig.
     */
    public function getTwig(): \Twig\Environment
    {
        return $this->twig;
    }

    /**
     * @brief Définit l'environnement Twig.
     *
     * @param \Twig\Environment $twig Environnement Twig à définir.
     */
    public function setTwig(\Twig\Environment $twig): void
    {
        $this->twig = $twig;
    }

    /**
     * @brief Obtient les données GET.
     *
     * @return array Données GET.
     */
    public function getGet(): array
    {
        return $this->get;
    }

    /**
     * @brief Définit les données GET.
     *
     * @param array $get Données GET à définir.
     */
    public function setGet(array $get): void
    {
        $this->get = $get;
    }

    /**
     * @brief Obtient les données POST.
     *
     * @return array Données POST.
     */
    public function getPost(): array
    {
        return $this->post;
    }

    /**
     * @brief Définit les données POST.
     *
     * @param array $post Données POST à définir.
     */
    public function setPost(array $post): void
    {
        $this->post = $post;
    }
}
