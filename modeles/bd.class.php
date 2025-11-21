<?php
// require_once "config/constantes.php";

class Bd
{
    // Instance statique unique de la classe Bd
    private static ?Bd $instance = null;

    // Instance de PDO pour la connexion à la base de données
    private ?PDO $pdo;

    private function __construct()
    {
        try
        {
            $this->pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,  DB_USER, DB_PASS);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e)
        {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    // Méthode statique pour obtenir l'instance unique
    public static function getInstance(): Bd
    {
        if (self::$instance === null)
        {
            self::$instance = new Bd();
        }
        return self::$instance;
    }
    // Méthode pour obtenir la connexion PDO
    public function getConnection(): PDO
    {
        return $this->pdo;
    }

    // Empêcher le clonage de l'instance
    private function __clone()
    {
    }

    // Empêcher la sérialisation de l'instance
    public function __wakeup()
    {
        throw new Exception("Un singleton ne doit pas être désérialisé");
    }
}
