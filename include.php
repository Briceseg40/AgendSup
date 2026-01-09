<?php
/* @file include.php
 * @brief Fichier d'inclusion des dépendances et des classes.
 *
 * Ce fichier inclut toutes les dépendances nécessaires,
 * les classes de modèles et les contrôleurs utilisés dans l'application.
 */
require_once 'vendor/autoload.php';
/* Inclusion des modèles */
require_once 'modeles/etudiant.dao.php'; 

require_once 'modeles/etudiant.class.php';

require_once 'config/twig.php';

require_once 'config/constantes.php';

require_once 'modeles/bd.class.php';

require_once "modeles/cours.class.php";

require_once "modeles/cours.dao.php";

require_once "modeles/agenda.class.php";

require_once "modeles/agenda.dao.php";

require_once "modeles/classe.class.php";

require_once "modeles/classe.dao.php";

require_once "modeles/devoir.class.php";

require_once "modeles/devoirdao.class.php";

require_once 'controllers/controller.class.php';

require_once 'controllers/controller_index.php';

require_once "controllers/controller_connecter.php";

require_once 'controllers/controller_cours.class.php';

require_once 'controllers/controller_classe.class.php';

//require_once 'controllers/controller_joinClass.class.php';

require_once 'controllers/controller_devoir.class.php';

require_once 'controllers/controller_factory.php';

require_once 'controllers/controller_register.php';

require_once 'controllers/controller_forgetpasseword.php';

require_once 'controllers/controller_param_classe.class.php';