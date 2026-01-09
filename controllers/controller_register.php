<?php
//Il faut hasher le mdp
/**
 * @file controller_register.php
 * @brief Contrôleur pour la gestion de la page d'inscription.
 *
 * Ce contrôleur permet d'afficher la page d'inscription
 * et de gérer le processus d'inscription des utilisateurs
 * via un template Twig.
 */ 
class ControllerRegister extends Controller {
    //Constructeur
    /**
     * @brief Constructeur du contrôleur d'inscription.
     *
     * @param \Twig\Loader\FilesystemLoader $loader Chargeur de templates Twig.
     * @param \Twig\Environment $twig Environnement Twig.
     */
    public function __construct(\Twig\Loader\FilesystemLoader $loader, \Twig\Environment $twig) {
        parent::__construct($loader, $twig);
    }

    //Register
    /**
     * @brief Gère le processus d'inscription des utilisateurs.
     *
     * Récupère les données du formulaire d'inscription,
     * crée un nouvel utilisateur et gère les erreurs potentielles.
     */
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $utilisateur = new Utilisateur($email, $password);

    try
    {
        $utilisateur->inscription();
        echo $this->getTwig()->render('connected.html.twig', ['user' => $_SESSION['user']]);
    }
    catch (Exception $e)
    {
    switch ($e->getMessage())
    {
        case "compte_existant":
            echo '<h1>Erreur : Compte existant</h1>';
            echo '<p>Ce compte existe déjà.</p>';
            echo '<a href="#">Mot de passe oublié ?</a><br>';
            echo '<a href="inscription.html">Retour au formulaire d\'inscription</a>';
            break;

        case "mdp_faible":
            echo '<h1>Erreur : Mot de passe invalide</h1>';
            echo '<p>Le mot de passe doit contenir au moins 8 caractères, une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial.</p>';
            echo '<a href="inscription.php">Retour au formulaire d\'inscription</a>';
            break;

        default:
            echo "<h1>Une erreur inattendue est survenue</h1>";
            echo "<p>{$e->getMessage()}</p>";
            echo '<a href="inscription.php">Retour au formulaire d\'inscription</a>';
            break;
    }
    }}}
    
    //Render
    /**
     * @brief Affiche la page d'inscription.
     */
    public function render() {
        echo $this->getTwig()->render('register.html.twig');
    }

    
}