<?php
/* @file controller_register.php
 * @brief Contrôleur pour la page d'inscription.
 * @author Baptiste Marsaa et Rémi Bouillon
 * @date 19/11/2025
 */
class ControllerRegister extends Controller {
    // Constructeur
    /**
     * @brief Constructeur de la classe ControllerRegister.
     * @param \Twig\Loader\FilesystemLoader $loader Chargeur de fichiers Twig.
     * @param \Twig\Environment $twig Environnement Twig.
     */
    public function __construct(\Twig\Loader\FilesystemLoader $loader, \Twig\Environment $twig) {
        parent::__construct($loader, $twig);
    }
    /**
     * @brief Gère le processus d'inscription.
     */
    public function register()
    {
        /* Règles de validation :
         * - email : obligatoire, format email
         * - name : obligatoire, longueur min 2
         * - first_name : obligatoire, longueur min 2
         * - password : obligatoire
         */
        $reglesValidation = [
            'email' => [
                'obligatoire' => true,
                'format' => FILTER_VALIDATE_EMAIL
            ],
            'name' => [
                'obligatoire' => true,
                'longueur_min' => 2
            ],
            'first_name' => [
                'obligatoire' => true,
                'longueur_min' => 2
            ],
            'password' => [
                'obligatoire' => true
            ]
        ];
        $validator = new Validator($reglesValidation);
        $valide = $validator->valider($_POST);
        $erreurs = $validator->getMessagesErreurs();

        // ERREURS DE FORMULAIRE
        /* @brief Si le formulaire n'est pas valide, on réaffiche le formulaire avec les erreurs. */
        if (!$valide) {
            echo $this->getTwig()->render('register.html.twig', [
                'errors' => $erreurs,
                'form_data' => $_POST
            ]);
            return; // STOP
        }

        /**
         * @brief Calcul de l'ID de la classe à partir de la promotion, du TD et du TP.
         */ 
        $promo = (int)$_POST['promo'];
        $td = (int)$_POST['td_group'];
        $tp = (int)$_POST['tp_group'];

        $idClasse = $promo * 100 + $td * 10 + $tp;
        /**
         * @brief Détermination du rôle de l'étudiant.
         */
        $roleCode = (int)($_POST['role'] ?? 1); // par défaut 1 = normal

        /* @brief Utilisation de match pour déterminer le rôle. */
        $role = match ($roleCode) {
            1 => 'normal',
            2 => 'délégué',
            3 => 'ressource',
            default => 'normal', // valeur par défaut
        };
        /**
         * @brief Création de l'objet Etudiant.
         */
        $etudiant = new Etudiant(
            null,
            $_POST['name'],
            $_POST['first_name'],
            $role,
            $promo,
            $idClasse,
            $_POST['email'],
            $_POST['password'],
            $_POST['parcours']
        );

        $pdo = Bd::getInstance()->getConnection();
        $etudiantDAO = new EtudiantDAO($pdo);

        /* @brief Tentative d'inscription de l'étudiant. */
        try {
            $etudiant->inscription($etudiantDAO);
        } catch (Exception $e) {
            echo $this->getTwig()->render('register.html.twig', [
                'errors' => [$e->getMessage()],
                'form_data' => $_POST
            ]);
            return; // STOP
        }

        // SUCCÈS 
        $this->success();
        exit();
    }

    /**
     * @brief Affiche la page de succès après une inscription réussie.
     */
    public function success()
    {
        echo $this->getTwig()->render('inscription_reussie.html.twig');
    }

    /**
     * @brief Rendu de la page d'inscription.
     */
    public function render() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->register();
            return;
        }

        echo $this->getTwig()->render('register.html.twig');
    }
}
