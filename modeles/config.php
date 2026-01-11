<?php
use Symfony\Component\Yaml\Yaml;
/* @file config.php
 * @brief Gestion de la configuration de l'application.
 * @author Guénolé Mourzelas
 * @date 11/01/2026
 */
class Config {
    /* @brief Instance unique de la classe Config.
     * @var Config|null
     */
    private static $instance = null;
    /* @brief Configuration de l'application.
     * @var array|null
     */
    private static $config = null;
    /* @brief Constructeur privé pour empêcher l'instanciation directe.
     */
    private function __construct() {
        try {
            // Vérifie bien le chemin vers ton fichier yml
            self::$config = Yaml::parseFile(__DIR__ . "/config/config.yml");
        } catch (Exception $e) {
            die('La récupération de la configuration a échoué : ' . $e->getMessage());
        }
    }
    /* @brief Récupère l'instance unique de la configuration.
     * @return array Configuration de l'application.
     */
    public static function getConfig() {
        if (self::$instance === null) {
            self::$instance = new Config();
        }
        return self::$config;
    }
}