<?php
/* @file controller_factory.php
 * @author Rémi Bouillon
 * @brief Usine de contrôleurs pour l'application AgendSup.
 * @details Cette classe fournit une méthode statique pour obtenir des instances de contrôleurs
 * en fonction du nom du contrôleur demandé.
 * @version 0.1
 * @date 19/11/2025
 */
class ControllerFactory
{
    /**
     * @brief Obtient une instance de contrôleur en fonction du nom fourni.
     * @param string $controleur Nom du contrôleur demandé.
     * @param \Twig\Loader\FilesystemLoader $loader Chargeur de fichiers Twig.
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