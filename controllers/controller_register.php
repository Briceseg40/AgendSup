<?php

class ControllerRegister extends Controller {

    public function __construct(\Twig\Loader\FilesystemLoader $loader, \Twig\Environment $twig) {
        parent::__construct($loader, $twig);
    }

    public function register() {
        $email = ($_POST['email'] ?? '');
        $role = $_POST['role'] ?? '';
        $nom = ($_POST['name'] ?? '');
        $prenom = ($_POST['first_name'] ?? ''); 
        $password = ($_POST['password'] ?? ''); 
        $promo = $_POST['promo'] ?? '';
        $td = $_POST['td_group'] ?? '';
        $parcours = $_POST['parcours'] ?? '';
        $tp = $_POST['tp_group'] ?? '';

        // Map role values
        $roleMap = [
            '1' => 'normal',
            '2' => 'delegue',
            '3' => 'ressource'
        ];
        $role = $roleMap[$role] ?? 'normal';

        // Validate data
        $validator = new Validator([
            'email' => ['obligatoire' => true, 'format' => FILTER_VALIDATE_EMAIL],
            'name' => ['obligatoire' => true, 'longueur_min' => 2, 'longueur_max' => 50],
            'first_name' => ['obligatoire' => true, 'longueur_min' => 2, 'longueur_max' => 50],
            'password' => ['obligatoire' => true, 'longueur_min' => 8],
            'promo' => ['obligatoire' => true],
            'td_group' => ['obligatoire' => true],
            'parcours' => ['obligatoire' => true],
            'tp_group' => ['obligatoire' => true]
        ]);

        $data = [
            'email' => $email,
            'name' => $nom,
            'first_name' => $prenom,
            'password' => $password,
            'promo' => $promo,
            'td_group' => $td,
            'parcours' => $parcours,
            'tp_group' => $tp
        ];

        $errors = [];
        if (!$validator->valider($data)) {
            $errors = $validator->getMessagesErreurs();
        }

        if (!empty($errors)) {
            // Remove password from form data for security
            unset($data['password']);
            echo $this->getTwig()->render('register.html.twig', ['errors' => $errors, 'form_data' => $data]);
            return;
        }

        // Check password complexity
        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\w\s]).{8,}$/', $password)) {
            unset($data['password']);
            echo $this->getTwig()->render('register.html.twig', ['error' => 'mdp_faible', 'form_data' => $data]);
            return;
        }

        // Check if email already exists
        $etudiantDAO = new EtudiantDAO(Bd::getInstance()->getConnection());
        if ($etudiantDAO->findByEmail($email)) {
            unset($data['password']);
            echo $this->getTwig()->render('register.html.twig', ['error' => 'compte_existant', 'form_data' => $data]);
            return;
        }

        // Create Etudiant object
        $idClasse = (int)$promo * 100 + (int)$td * 10 + (int)$tp;
        $etudiant = new Etudiant(null, $nom, $prenom, $role, (int)$promo, $idClasse, $email, $password);

        try {
            if ($etudiantDAO->insert($etudiant)) {
                // Set session
                $pdo = Bd::getInstance()->getConnection();
                $_SESSION['user'] = [
                    'id' => $pdo->lastInsertId(),
                    'nom' => $nom,
                    'prenom' => $prenom,
                    'role' => $role,
                    'email' => $email
                ];
                echo $this->getTwig()->render('connected.html.twig', ['user' => $_SESSION['user']]);
            } else {
                unset($data['password']);
                echo $this->getTwig()->render('register.html.twig', ['error' => 'Erreur lors de l\'inscription', 'form_data' => $data]);
            }
        } catch (Exception $e) {
            unset($data['password']);
            echo $this->getTwig()->render('register.html.twig', ['error' => $e->getMessage(), 'form_data' => $data]);
        }
    }

    public function render() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->register();
        } else {
            echo $this->getTwig()->render('register.html.twig');
        }
    }
}