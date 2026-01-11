<?php
/* @file controller_paramClasse.class.php
 * @brief Contrôleur pour la création de classe et paramètres associés.
 * @author Guénolé Mourzelas
 * @date 20/12/2025
 */
class ControllerParamClasse extends Controller
{
    // Constructeur
    /**
     * @brief Constructeur de la classe ControllerParamClasse.
     * @param \Twig\Loader\FilesystemLoader $loader Chargeur de fichiers Twig.
     * @param \Twig\Environment $twig Environnement Twig.
     */
    public function __construct(\Twig\Loader\FilesystemLoader $loader, \Twig\Environment $twig)
    {
        parent::__construct($loader, $twig);
    }

    /**
     * @brief Rendu de la page de création de classe.
     */
    public function render()
    {
        echo $this->getTwig()->render('createClassAndParam.html.twig');
    }

    /**
     * @brief Gère la création d'une nouvelle classe.
     */
    public function creer()
    {
        /* @brief Vérification de la session utilisateur. */
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?controleur=connecter&methode=connexion');
            exit();
        }
        /* @brief Récupération de l'utilisateur connecté. */
        $sessionUser = $_SESSION['user'];
        /* @brief Initialisation de l'objet utilisateur connecté. */
        $utilisateurConnecte = null;
        /* @brief Conversion du tableau utilisateur en objet Etudiant si nécessaire. */
        if (is_array($sessionUser)) {
            $utilisateurConnecte = new Etudiant(
                $sessionUser['id'],
                $sessionUser['nom'],
                $sessionUser['prenom'],
                $sessionUser['role'],
                (int)($sessionUser['annee'] ?? 1),
                $sessionUser['idClasse'] ?? 0,
                $sessionUser['email'],
                '' 
            );
        } 
        /* @brief Utilisation directe de l'objet utilisateur si déjà un objet. */
        else {
            $utilisateurConnecte = $sessionUser;
        }
        $anneeEtudiant = $utilisateurConnecte->getAnnee();
        $idEtudiant = $utilisateurConnecte->getId();
        $idCompose = $utilisateurConnecte->getIdClasse();
        /* @brief Extraction des TD et TP à partir de l'ID composé. */
        $tdEtudiant = floor(($idCompose % 100) / 10);
        /* @brief Extraction du TP à partir de l'ID composé. */
        $tpEtudiant = $idCompose % 10;

        /* @brief Vérification de la méthode de la requête. */
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'] ?? '';
            $code = $_POST['code'] ?? '';
            $nomFichierImage = $_POST['image'] ?? 'agendboyquisait.png';
            $image = 'public/assets/img/' . $nomFichierImage;
            $description = $_POST['description'] ?? '';

            $pdo = Bd::getInstance()->getConnection();
            $classeDAO = new ClasseDAO($pdo);

            /* @brief Vérification de l'unicité du code de la classe. */
            if ($classeDAO->findCode($code)) {
                echo $this->getTwig()->render('createClassAndParam.html.twig', ['error' => 'Ce code de classe existe déjà']);
                return;
            }
            /* @brief Création de la nouvelle classe. */
            $nouvelleClasse = new Classe(
                null,
                $image,
                $nom,
                $description,
                $tdEtudiant,
                $tpEtudiant,
                $idEtudiant,
                $anneeEtudiant,
                $code
            );
            /* @brief Insertion de la nouvelle classe dans la base de données. */
            $classeDAO->create($nouvelleClasse);
            /* @brief Redirection vers la page de rejoindre une classe. */
            header('Location: index.php?controleur=joinClass&methode=render');
            exit();
        }
        /* @brief Rendu de la page de création de classe. */
        $this->render();
    }
}