<?php

/**
* @file    controller_etudiant.class.php
* @author  Guénolé Mourzelas
* @brief   Contrôleur gérant les opérations liées aux étudiants.
* @details Il permet d'afficher, lister, créer, modifier et supprimer
* des étudiants en s'appuyant sur le moteur de templates Twig.
* @version 0.1
* @date    19/12/2025
 */
class ControllerEtudiant extends Controller
{
public function __construct(\Twig\Loader\FilesystemLoader $loader, \Twig\Environment $twig)
{
parent::__construct($loader, $twig);
}


// Afficher un étudiant
public function afficher(): void
{
$template = $this->getTwig()->load('etudiant/afficher.twig');


echo $template->render([
"titre" => "Afficher un étudiant"
]);
}


// Lister tous les étudiants
public function lister(): void
{
$template = $this->getTwig()->load('etudiant/lister.twig');


echo $template->render([
"titre" => "Liste des étudiants"
]);
}


// Créer un étudiant
public function creer(): void
{
$template = $this->getTwig()->load('etudiant/creer.twig');


echo $template->render([
"titre" => "Créer un étudiant"
]);
}


// Modifier un étudiant
public function modifier(): void
{
$template = $this->getTwig()->load('etudiant/modifier.twig');


echo $template->render([
"titre" => "Modifier un étudiant"
]);
}


// Supprimer un étudiant
public function supprimer(): void
{
$template = $this->getTwig()->load('etudiant/supprimer.twig');


echo $template->render([
"titre" => "Supprimer un étudiant"
]);
}
}