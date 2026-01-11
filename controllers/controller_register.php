<?php

class ControllerRegister extends Controller {

    public function __construct(\Twig\Loader\FilesystemLoader $loader, \Twig\Environment $twig) {
        parent::__construct($loader, $twig);
    }

    public function register()
    {
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
        if (!$valide) {
            echo $this->getTwig()->render('register.html.twig', [
                'errors' => $erreurs,
                'form_data' => $_POST
            ]);
            return; // STOP
        }

        // DONNÉES
        $promo = (int)$_POST['promo'];
        $td = (int)$_POST['td_group'];
        $tp = (int)$_POST['tp_group'];

        $idClasse = $promo * 100 + $td * 10 + $tp;

        $roleCode = (int)($_POST['role'] ?? 1); // par défaut 1 = normal

        // Traduction en libellé
        $role = match ($roleCode) {
            1 => 'normal',
            2 => 'delegue',
            3 => 'ressource',
            default => 'normal', // valeur par défaut
        };

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

        // ERREURS 
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
        header('Location: index.php?controleur=register&methode=success');
        exit();
    }

    public function success()
    {
        echo $this->getTwig()->render('inscription_reussie.html.twig');
    }

    public function render() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->register();
            return;
        }

        echo $this->getTwig()->render('register.html.twig');
    }
}
