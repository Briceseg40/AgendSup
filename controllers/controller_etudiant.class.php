<?php
/**
 * @file    controller_etudiant.class.php
 * @brief   Contrôleur pour la gestion des étudiants.
 * @details Cette classe gère les actions liées aux étudiants
 * dans le système AgendSup.
 * @version 0.1
 * @date    19/11/2025
 */
class ControllerEtudiant extends Controller
{
// Constructeur
/**
 * @brief Constructeur de la classe ControllerEtudiant.
 * @param \Twig\Loader\FilesystemLoader $loader Chargeur de fichiers Twig.
 * @param \Twig\Environment $twig Environnement Twig.
 */
public function __construct(\Twig\Loader\FilesystemLoader $loader, \Twig\Environment $twig)
{
parent::__construct($loader, $twig);
}

/**
 * @brief Afficher un étudiant.
 * @return void
 */
public function afficher(): void
{
/* @brief Chargement du template Twig pour afficher un étudiant. */
$template = $this->getTwig()->load('etudiant/afficher.twig');
/* @brief Rendu du template avec le titre de la page. */
echo $template->render([
"titre" => "Afficher un étudiant"
]);
}

/**
 * @brief Lister les étudiants.
 * @return void
 */
public function lister(): void
{
$template = $this->getTwig()->load('etudiant/lister.twig');


echo $template->render([
"titre" => "Liste des étudiants"
]);
}


/**
 * @brief Créer un étudiant.
 * @return void
 */
public function creer(): void
{
/* @brief Chargement du template Twig pour créer un étudiant. */
$template = $this->getTwig()->load('etudiant/creer.twig');
/* @brief Rendu du template avec le titre de la page. */
echo $template->render([
"titre" => "Créer un étudiant"
]);
}

/**
 * @brief Modifier un étudiant.
 * @return void
 */
public function modifier(): void
{
/* @brief Chargement du template Twig pour modifier un étudiant. */
$template = $this->getTwig()->load('etudiant/modifier.twig');
/* @brief Rendu du template avec le titre de la page. */
echo $template->render([
"titre" => "Modifier un étudiant"
]);
}

/**
 * @brief Supprimer un étudiant.
 * @return void
 */
public function supprimer(): void
{
/* @brief Chargement du template Twig pour supprimer un étudiant. */
$template = $this->getTwig()->load('etudiant/supprimer.twig');
/* @brief Rendu du template avec le titre de la page. */
echo $template->render([
"titre" => "Supprimer un étudiant"
]);
}
}

/**
 * @brief Afficher le profil de l'étudiant connecté.
 * @return void
 */
public function afficher(): void
{
    // On récupère l'étudiant connecté en session (exemple)
    // Ou on le récupère via un ID passé en paramètre
    $etudiant = $_SESSION['user_object'] ?? null; 

    $template = $this->getTwig()->load('etudiant/afficher.twig');
    echo $template->render([
        "titre" => "Mon Profil",
        "etudiant" => $etudiant
    ]);
}
