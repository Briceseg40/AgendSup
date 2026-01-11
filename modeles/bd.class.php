<?php
require_once "config/constantes.php";
/**
 * @class Bd
 * @brief Classe singleton pour la gestion de la connexion à la base de données.
 *
 * Cette classe utilise le pattern Singleton pour garantir qu'une seule
 * instance de connexion à la base de données est créée et utilisée
 * tout au long de l'application.
 */

class Bd
{
    /** @brief Instance unique de la classe Bd
     */
    private static ?Bd $instance = null;

    /** @brief Instance de PDO pour la connexion à la base de données
     */
    private ?PDO $pdo;

    /** @brief Constructeur de la classe Bd.
     * @details Initialise la connexion à la base de données en utilisant PDO.
     */
    private function __construct()
    {
        try
        {
            $this->pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',  DB_USER, DB_PASS);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        }
        catch (PDOException $e)
        {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    /**
     * @brief Obtient l'instance unique de la classe Bd.
     * @return Bd Instance unique de Bd.
     */
    public static function getInstance(): Bd
    {
        if (self::$instance === null)
        {
            self::$instance = new Bd();
        }
        return self::$instance;
    }

    /**
     * @brief Obtient l'instance de PDO.
     * @return PDO Instance de PDO.
     */
    public function getConnection(): PDO
    {
        return $this->pdo;
    }

    /**
     * @brief Empêcher le clonage de l'instance
     */
    private function __clone()
    {
    }

    /**
     * @brief Empêcher la sérialisation de l'instance
     */
    public function __wakeup()
    {
        throw new Exception("Un singleton ne doit pas être désérialisé");
    }
}
