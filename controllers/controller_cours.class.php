<?php
/* @file controller_cours.class.php
 * @author Rémi Bouillon et Brice Seguret
 * @brief Contrôleur pour la gestion des cours.
 * @details Ce contrôleur gère les actions liées aux cours,
 * telles que la liste, la création, la modification et la suppression.
 * @version 0.1
 * @date 19/11/2025
 */
class controllerCours extends Controller
{
    // Constructeur
    /**
     * @brief Constructeur de la classe controllerCours.
     * @param \Twig\Loader\FilesystemLoader $loader Chargeur de fichiers Twig.
     * @param \Twig\Environment $twig Environnement Twig.
     */
    public function __construct(\Twig\Loader\FilesystemLoader $loader, \Twig\Environment $twig)
    {
        parent::__construct($loader, $twig);
    }

    /**
     * @brief Liste tous les cours.
     */
    public function lister(): void
    {
        $manager = new CoursDao($this->getPdo());
        $cours = $manager->findAll();

        //Chargement du template
        $template = $this->getTwig()->load('cours.twig');

        //Affichage du template et transmission des données
        echo $template->render(array(
            'categories' => $cours,
        ));
    }

    /**
     * @brief Liste les cours filtrés par année et parcours de l'utilisateur.
     * @param int $Annee Année pour filtrer les cours.
     */
    public function findByAnnee($Annee): void{

    $parcours = $_SESSION['user']['Parcour'] ?? null; 

    $manager = new CoursDao($this->getPdo());
    $listeDesCours = $manager->findByAnneeEtParcours((int)$Annee, $parcours);

    $template = $this->getTwig()->load('cours.twig');

    echo $template->render(array(
        'lesCours' => $listeDesCours,
        'menu' => "category"
    ));
    }

}
