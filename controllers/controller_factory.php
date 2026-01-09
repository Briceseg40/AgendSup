<?php
/**
 * @file controller_factory.php
 * @brief Usine de contrôleurs.
 *
 * Cette classe permet de créer des instances de contrôleurs
 * en fonction du nom fourni.
 */
class ControllerFactory
{
    /**
     * @brief Crée une instance de contrôleur.
     *
     * @param string $controleur Nom du contrôleur à créer.
     * @param \Twig\Loader\FilesystemLoader $loader Chargeur de templates Twig.
     * @param \Twig\Environment $twig Environnement Twig.
     * @return mixed Instance du contrôleur demandé.
     * @throws Exception Si le contrôleur n'existe pas.
     */
    public static function getController($controleur, \Twig\Loader\FilesystemLoader $loader, \Twig\Environment $twig)
    {
        $controllerName = "Controller" . ucfirst($controleur);

        if (!class_exists($controllerName)) {
            throw new Exception("Le controleur $controllerName n'existe pas");
        }

        return new $controllerName($loader, $twig);
    }
}