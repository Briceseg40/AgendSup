<?php
use Symfony\Component\Yaml\Yaml;

class Config {
    private static $instance = null;
    private static $config = null;

    private function __construct() {
        try {
            self::$config = Yaml::parseFile(__DIR__ . "/config.yml");
        } catch (Exception $e) {
            die('Erreur YAML : ' . $e->getMessage());
        }
    }

    public static function getConfig() {
        if (self::$instance === null) {
            self::$instance = new Config();
        }
        return self::$config;
    }
}