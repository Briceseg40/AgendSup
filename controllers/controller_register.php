<?php
//Il faut hasher le mdp, 
class ControllerRegister extends Controller {

    public function __construct(\Twig\Loader\FilesystemLoader $loader, \Twig\Environment $twig) {
        parent::__construct($loader, $twig);
    }

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
    

    public function render() {
        echo $this->getTwig()->render('register.html.twig');
    }

    
}