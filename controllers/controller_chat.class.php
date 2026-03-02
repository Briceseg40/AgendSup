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
     * @brief Liste les chats de l'utilisateur et gère l'affichage de la discussion active.
     */
    public function lister(): void
    {
        // 1. Sécurité : Vérifier que l'utilisateur est connecté
        if (!isset($_SESSION['user']) || !is_object($_SESSION['user'])) {
            header("Location: ?controleur=connecter&methode=render");
            exit();
        }

        $idMoi = $_SESSION['user']->getId();
        $pdo = $this->getPdo();
        $chatManager = new ChatDAO($pdo);
        $etudiantManager = new EtudiantDAO($pdo);

        // 2. Récupérer l'ID du chat sélectionné dans l'URL (si présent)
        $idActive = $_GET['id_chat'] ?? null;

        // --- LOGIQUE DES NOTIFICATIONS : MARQUER COMME LU ---
        if ($idActive) {
            // Dès qu'on clique sur un chat, on passe tous les messages reçus de ce chat à "lu" (is_read = 1)
            // Cela fera disparaître ou diminuer le chiffre dans la bulle rouge
            $sqlRead = "UPDATE recevoir SET is_read = 1 WHERE idChat = ? AND idEtudiant = ? AND is_read = 0";
            $stmtRead = $pdo->prepare($sqlRead);
            $stmtRead->execute([(int)$idActive, $idMoi]);
        }

        // 3. Récupérer les données pour la Sidebar (Liste des discussions de l'étudiant)
        $chats = $chatManager->findChatsByEtudiant($idMoi);

        // 4. Récupérer tous les étudiants pour la modale de création de groupe
        $etudiants = $etudiantManager->findAll();

        // --- LOGIQUE DES NOTIFICATIONS : COMPTER LE TOTAL ---
        // On compte combien de messages l'utilisateur n'a pas encore lus au total (tous chats confondus)
        // Cette variable sera utilisée dans base.html.twig pour la bulle rouge
        $unreadCount = $chatManager->countUnreadMessages($idMoi);

        // 5. Gérer le chat actif et charger ses messages
        $messages = [];
        $activeChat = null;

        if ($idActive) {
            $activeChat = $chatManager->findById((int)$idActive);
            
            // Si le chat existe bien, on charge la conversation complète
            if ($activeChat) {
                $messages = $chatManager->getMessagesByChat((int)$idActive, $idMoi);
            }
        }

        // 6. Affichage du template Twig avec toutes les variables nécessaires
        $template = $this->getTwig()->load('chat.html.twig');
        echo $template->render([
            'chats'       => $chats,        // Liste des chats à gauche
            'etudiants'   => $etudiants,    // Liste pour la modale de création
            'messages'    => $messages,     // Bulles de messages au centre
            'activeChat'  => $activeChat,   // Infos du chat sélectionné (nom, etc.)
            'idActive'    => $idActive,     // ID pour mettre en surbrillance le chat dans la liste
            'unreadCount' => $unreadCount   // Nombre pour la bulle rouge style Apple
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
    if (isset($_GET['id'])) {
        $idChat = (int)$_GET['id'];
        $pdo = $this->getPdo();

        try {
            $pdo->beginTransaction();

            // 1. Supprimer les messages liés dans 'Envoyer'
            $stmt1 = $pdo->prepare("DELETE FROM envoyer WHERE idChat = ?");
            $stmt1->execute([$idChat]);

            // 2. Supprimer les messages liés dans 'recevoir'
            $stmt2 = $pdo->prepare("DELETE FROM recevoir WHERE idChat = ?");
            $stmt2->execute([$idChat]);

            // 3. Supprimer le chat lui-même
            $stmt3 = $pdo->prepare("DELETE FROM chat WHERE id = ?");
            $stmt3->execute([$idChat]);

            $pdo->commit();
        } catch (Exception $e) {
            $pdo->rollBack();
            die("Erreur lors de la suppression : " . $e->getMessage());
        }
    }

    // Redirection vers la page principale des chats
    header("Location: ?controleur=chat&methode=lister");
    exit();
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
                    $sqlEnv = "INSERT INTO envoyer (idEtudiant, idChat, date_message, contenu) 
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
                $sqlEnv = "INSERT INTO envoyer (idEtudiant, idChat, date_message, contenu) 
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