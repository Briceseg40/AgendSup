<?php

class Bd
{
    private static ?Bd $instance = null;
    private ?PDO $pdo;

    private function __construct()
    {
        $config = Config::getConfig();
        
        $dbHost = $config['db']['host'];
        $dbName = $config['db']['name']; 
        $dbUser = $config['db']['user'];
        $dbPass = $config['db']['password'] ?? ''; 

        try
        {
            $dsn = "mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4";
            
            $this->pdo = new PDO($dsn, $dbUser, $dbPass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        }
        catch (PDOException $e)
        {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    public static function getInstance(): Bd
    {
        if (self::$instance === null) {
            self::$instance = new Bd();
        }
        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->pdo;
    }

    private function __clone(){}
    public function __wakeup()
    {
        throw new \Exception("Erreur impossible de deserialize un singleton.");
    }
}

