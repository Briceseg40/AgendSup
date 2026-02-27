<?php
/** @file    controller_chat.class.php
* @author  Rémi Montignac
* @brief   Contrôleur pour la gestion des chats.
* @version 0.1
* @date    19/12/2025
*/
class ControllerChat extends Controller
{
    // Constructeur
    /**
     * @brief Constructeur de la classe ControllerChat.
     * @param \Twig\Loader\FilesystemLoader $loader Chargeur de fichiers Twig.
     * @param \Twig\Environment $twig Environnement Twig.
     */
    public function __construct(\Twig\Loader\FilesystemLoader $loader, \Twig\Environment $twig)
    {
        parent::__construct($loader, $twig);
    }
        
    /**
     * @brief Liste tous les chats.
     */
    public function lister(): void
    {
        $idMoi = $_SESSION['user']->getId();
        $manager = new ChatDAO($this->getPdo());

        // 1. Liste pour l'Offcanvas (dernier message)
        $chatsRecents = $manager->findChatsRecents($idMoi);

        // 2. Si un chat est sélectionné, on récupère toute la conversation
        $idActive = $_GET['id_chat'] ?? null;
        $messages = [];
        $activeChat = null;

        if ($idActive) {
            $activeChat = $manager->findById((int)$idActive);
            $messages = $manager->getMessagesByChat((int)$idActive, $idMoi);
        }

        $template = $this->getTwig()->load('chat.html.twig');
        echo $template->render([
            'chatsRecents' => $chatsRecents,
            'messages' => $messages,
            'activeChat' => $activeChat,
            'idActive' => $idActive,
            'etudiants' => (new EtudiantDAO($this->getPdo()))->findAll()
        ]);
    }

    /**
     * @brief Liste les chats où un utilisateur spécifique a parlé.
     * @param int $id_utilisateur Identifiant de l'utilisateur.
     */
    public function listerByUtilisateur(int $id_utilisateur): void
    {
        $manager = new ChatDAO($this->getPdo());
        // la méthode attend un tableau d'ids, on passe un tableau avec 1 id
        $chats = $manager->findChatsOuUtilisateurAParle([$id_utilisateur]);

        $template = $this->getTwig()->load('chat.twig');

        echo $template->render([
            'chats' => $chats,
            'menu' => 'chat_by_user',
            'userId' => $id_utilisateur
        ]);
    }

    /**
     * @brief Liste les chats où au moins un des utilisateurs spécifiés a parlé.
     * @param array $userIds Tableau des identifiants des utilisateurs.
     */
    public function listerByUtilisateurs(array $userIds): void
    {
        $manager = new ChatDAO($this->getPdo());
        $chats = $manager->findChatsOuUtilisateurAParle($userIds);

        $template = $this->getTwig()->load('chat.twig');

        echo $template->render([
            'chats' => $chats,
            'menu' => 'chat_by_users'
        ]);
    }

    /**
     * @brief Crée un nouveau chat.
     */
    public function creer(): void
    {
        $template = $this->getTwig()->load('chat.creer.html.twig');

        echo $template->render([
            "titre" => "Créer un chat"
        ]);
    }

    /**
     * @brief Modifie un chat existant.
     */
    public function modifier(): void
    {
        $template = $this->getTwig()->load('chat/modifier.twig');

        echo $template->render([
            "titre" => "Modifier un chat"
        ]);
    }

    /**
     * @brief Supprime un chat existant.
     */
    public function supprimer(): void
    {
        $template = $this->getTwig()->load('chat/supprimer.twig');

        echo $template->render([
            "titre" => "Supprimer un chat"
        ]);
    }

   public function enregistrer(): void
    {
        // 1. Vérification du formulaire
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['nom_chat'])) {
            $pdo = $this->getPdo();
            
            // 2. Récupération de l'ID de l'utilisateur (depuis l'objet en session)
            if (isset($_SESSION['user']) && is_object($_SESSION['user'])) {
                $idMoi = $_SESSION['user']->getId(); 
            } else {
                die("Erreur : Vous n'êtes pas connecté.");
            }

            $nomChat = $_POST['nom_chat'];
            $nouveauChat = new Chat(null, $nomChat);
            $manager = new ChatDAO($pdo);
            
            // 3. Création du chat et récupération de l'ID auto-incrémenté
            $idChat = $manager->ajouterEtRecupererId($nouveauChat);

            if ($idChat) {
                try {
                    $pdo->beginTransaction();

                    // --- 4. INSERTION DANS 'Envoyer' (Le créateur / Toi) ---
                    // Colonnes confirmées : idEtudiant, idChat, date_message, contenu
                    $sqlEnv = "INSERT INTO Envoyer (idEtudiant, idChat, date_message, contenu) 
                            VALUES (:idEtudiant, :idChat, NOW(), :contenu)";
                    $stmtEnv = $pdo->prepare($sqlEnv);
                    $stmtEnv->execute([
                        ':idEtudiant' => $idMoi,
                        ':idChat'     => $idChat,
                        ':contenu'    => "Discussion créée : " . $nomChat
                    ]);

                    // --- 5. INSERTION DANS 'recevoir' (Les participants / Eux) ---
                    // Colonnes confirmées : idEtudiant, idChat, dateMessage, contenu
                    if (!empty($_POST['participants']) && is_array($_POST['participants'])) {
                        $sqlRec = "INSERT INTO recevoir (idEtudiant, idChat, dateMessage, contenu) 
                                VALUES (:idEtudiant, :idChat, NOW(), :contenu)";
                        $stmtRec = $pdo->prepare($sqlRec);

                        foreach ($_POST['participants'] as $idParticipant) {
                            $stmtRec->execute([
                                ':idEtudiant' => (int)$idParticipant,
                                ':idChat'     => $idChat,
                                ':contenu'    => "Vous avez été ajouté au groupe."
                            ]);
                        }
                    }

                    $pdo->commit();
                    
                    // Redirection vers la liste des chats
                    header("Location: ?controleur=chat&methode=lister");
                    exit();

                } catch (Exception $e) {
                    $pdo->rollBack();
                    // Affiche l'erreur exacte si un nom de colonne manque encore
                    die("Erreur lors de l'enregistrement : " . $e->getMessage());
                }
            } else {
                die("Erreur : Impossible de créer le chat dans la table principale.");
            }
        } else {
            header("Location: ?controleur=chat&methode=lister");
            exit();
        }
    }

    public function envoyer(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['message']) && !empty($_POST['id_chat'])) {
            $pdo = $this->getPdo();
            $idChat = (int)$_POST['id_chat'];
            $contenu = $_POST['message'];

            // 1. Récupérer ton ID
            if (isset($_SESSION['user']) && is_object($_SESSION['user'])) {
                $idMoi = $_SESSION['user']->getId();
            } else {
                die("Erreur : Non connecté.");
            }

            try {
                $pdo->beginTransaction();

                // 2. Enregistrer ton message dans 'Envoyer'
                $sqlEnv = "INSERT INTO Envoyer (idEtudiant, idChat, date_message, contenu) 
                        VALUES (:u, :c, NOW(), :msg)";
                $stmtEnv = $pdo->prepare($sqlEnv);
                $stmtEnv->execute([
                    ':u'   => $idMoi,
                    ':c'   => $idChat,
                    ':msg' => $contenu
                ]);

                // 3. Récupérer tous les participants du chat pour leur envoyer
                $manager = new ChatDAO($pdo);
                $participants = $manager->getParticipantsIds($idChat);

                // 4. Enregistrer dans 'recevoir' pour tous les autres
                $sqlRec = "INSERT INTO recevoir (idEtudiant, idChat, dateMessage, contenu) 
                        VALUES (:u, :c, NOW(), :msg)";
                $stmtRec = $pdo->prepare($sqlRec);

                foreach ($participants as $idParticipant) {
                    if ((int)$idParticipant !== (int)$idMoi) { 
                        $stmtRec->execute([
                            ':u'   => $idParticipant,
                            ':c'   => $idChat,
                            ':msg' => $contenu
                        ]);
                    }
                }

                $pdo->commit();
                
                // Rediriger pour vider le formulaire et voir le message
                header("Location: ?controleur=chat&methode=lister&id_chat=" . $idChat);
                exit();

            } catch (Exception $e) {
                $pdo->rollBack();
                die("Erreur lors de l'envoi : " . $e->getMessage());
            }
        }
    }
}