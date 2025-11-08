<?php

/**
 * @file twig.php
 * @brief Ce fichier contient l'initialisation et la configuration de Twig pour le rendu des templates.
 */

use Twig\Extra\Intl\IntlExtension;

/* 
Pour manipuler le fichier de configuration YAML dans les templates 
Nécessite que la bibliothèque Symfony/Yaml soit installée :
composer require symfony/yaml
*/
use Symfony\Component\Yaml\Yaml;

/**
 * @brief Chargement des templates contenus dans le dossier templates.
 */
$loader = new Twig\Loader\FilesystemLoader('templates');

//Paramétrage de l'environnement twig

/**
 * @brief Environnement Twig.
 *
 * Passe en mode debug pour afficher le contenu d'une variable dans un template avec {{ dump(variable) }}.
 * 
 * @remark Nécessite l'utilisation de l'extension debug
 * @warning À désactiver en environnement de production
 */
$twig = new Twig\Environment($loader, [
    'debug' => true,
    // Il est possible de définir d'autre variable d'environnement
    //...
]);

// Définition de la timezone pour Twig.
//$twig->getExtension(\Twig\Extension\CoreExtension::class)->setTimezone('Europe/Paris');

// Ajout de l'extension Debug pour Twig.
$twig->addExtension(new \Twig\Extension\DebugExtension());

// Ajout de l'extension d'internationalisation pour Twig.
//$twig->addExtension(new IntlExtension());