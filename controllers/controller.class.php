<?php
/**
 * @file controller.class.php
 * @brief Définit la classe Controller de base pour les contrôleurs.
 * @author Rémi Bouillon
 * @date 19/06/2024
 */
class Controller
{
    /** @brief Instance de PDO pour la connexion à la base de données */
    private PDO $pdo;
    /** @brief Instance du chargeur de templates Twig */
    private \Twig\Loader\FilesystemLoader $loader;
    /** @brief Instance de l'environnement Twig */
    private \Twig\Environment $twig;
    /** @brief Données GET de la requête */
    private ?array $get = null;
    /** @brief Données POST de la requête */
    private ?array $post = null;

    /** 
     * @brief Constructeur de la classe Controller.
     * @param \Twig\Loader\FilesystemLoader $loader Chargeur de fichiers Twig.
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

    /**
     * @brief Appelle une méthode du contrôleur de manière dynamique.
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

    /** Getters et Setters */
    /**
     * @brief Obtient l'instance de PDO.
     * @return PDO|null
     */
    public function getPdo(): ?PDO
    {
        return $this->pdo;
    }

    /**
     * @brief Définit l'instance de PDO.
     * @param PDO $pdo
     */
    public function setPdo(PDO $pdo): void
    {
        $this->pdo = $pdo;
    }

    /**
     * @brief Obtient l'instance du chargeur de templates Twig.
     * @return \Twig\Loader\FilesystemLoader
     */
    public function getLoader(): \Twig\Loader\FilesystemLoader
    {
        return $this->loader;
    }

    /**
     * @brief Définit l'instance du chargeur de templates Twig.
     * @param \Twig\Loader\FilesystemLoader $loader
     */
    public function setLoader(\Twig\Loader\FilesystemLoader $loader): void
    {
        $this->loader = $loader;
    }

    /**
     * @brief Obtient l'instance de l'environnement Twig.
     * @return \Twig\Environment
     */
    public function getTwig(): \Twig\Environment
    {
        return $this->twig;
    }

    /**
     * @brief Définit l'instance de l'environnement Twig.
     * @param \Twig\Environment $twig
     */
    public function setTwig(\Twig\Environment $twig): void
    {
        $this->twig = $twig;
    }

    /**
     * @brief Obtient les données GET de la requête.
     * @return array
     */
    public function getGet(): array
    {
        return $this->get;
    }

    /**
     * @brief Définit les données GET de la requête.
     * @param array $get
     */
    public function setGet(array $get): void
    {
        $this->get = $get;
    }

    /**
     * @brief Obtient les données POST de la requête.
     * @return array
     */
    public function getPost(): array
    {
        return $this->post;
    }

    /**
     * @brief Définit les données POST de la requête.
     * @param array $post
     */
    public function setPost(array $post): void
    {
        $this->post = $post;
    }
}
