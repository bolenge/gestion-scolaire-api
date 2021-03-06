<?php
    /**
     * La localisation (langue) française de l'application
     */

    $error_persiste = "(Si cette erreur persiste veuillez contacter le service de développement UHTEC)";

    return [
        'admins' => [
            'login' => [
                'username_invalid' => 'Ce compte n\'existe pas',
                'password_invalid' => "Mot de passe incorrect",
                'success' => "Admin trouvé avec succès",
                'username_or_password_invalid' => "Nom d'utilisateur ou Mot de passe incorrect",
                'account_blocked' => "Votre compte a été bloqué (supendu) <br/><br/> Veuillez contacter le supper admin ou l'équipe de développement UHTEC"
            ],

            'logout' => [
                'username_invalid' => 'Ce compte n\'existe pas',
                'password_invalid' => "Mot de passe incorrect",
                'success' => "Admin déconnecté avec succès",
                'username_or_password_invalid' => "Nom d'utilisateur ou Mot de passe incorrect",
                'account_blocked' => "Votre compte a été bloqué (supendu) <br/><br/> Veuillez contacter le supper admin ou l'équipe de développement UHTEC"
            ],

            "create" => [
                "email_used" => "Adresse email déjà utilisé pour un autre compte admin",
                "role_invalid" => "Rôle de l'admin est invalide",
                "username_used" => "Nom d'utilisateur déjà utilisé pour un autre compte",
                'success' => "Admin créé avec succès",
                'warning' => "Une erreur est survenue lors de la création de l'admin ".$error_persiste,
                "id_acteur_invalid" => "ID acteur de données de l'admin est invalide"
            ],

            "find" => [
                "success" => "Admin(s) trouvé(s) avec succès",
                "nothing" => "Aucun admin trouvé pour cet ID",
                "invalid_id" => "Veuillez renseigner un ID de l'admin valide"
            ],

            'update' => [
                'success' => "Modification de l'admin faite avec succès",
                'warning' => "Une erreur est survenue lors de la mofication de l'admin ".$error_persiste,
                'desactive' => "Cet admin a été désactivé, vous ne pouvez pas modifier ses données. Veuillez le réactiver avant de les modifier."
            ],

            "desactive" => [
                "already_desactived" => "Cet admin est déjà désactivé",
                "success" => "Admin désactivé avec succès",
                "warning" => "Une erreur est survenue lors de la désactivation de l'admin ".$error_persiste,
            ],

            "active" => [
                "already_actived" => "Cet admin est déjà activé",
                "success" => "Admin activé avec succès",
                "warning" => "Une erreur est survenue lors de la l'activation de l'admin ".$error_persiste,
            ],
        ],

        'ecoles' => [
            'create' => [
                'success' => "L'école est créée avec succès",
                'warning' => "Une erreur est survenue lors de la création de l'école ".$error_persiste,
                'num_agrement_in_used' => "le numéro d'agrément est déjà utilisé pour une autre école",
                'id_media_logo_invalid' => "ID du média du logo est invalide (ou logo invalide)"
            ],
            'update' => [
                'success' => "Modification de données de l'école faite avec succès",
                'warning' => "Une erreur est survenue lors de la mofication de l'école ".$error_persiste,
                'desactive' => "Cette école a été désactivée, vous ne pouvez pas modifier ses données. Veuillez la réactiver avant de la modifier."
            ],
            'verify' => [
                'empty' => "Aucune école trouvée pour cet ID"
            ],
            "desactive" => [
                "already_desactived" => "Cette école est déjà désactivée",
                "success" => "Ecole désactivée avec succès",
                "warning" => "Une erreur est survenue lors de la désactivation de l'école ".$error_persiste,
            ],
            "active" => [
                "already_actived" => "Cette école est déjà activée",
                "success" => "Ecole activée avec succès",
                "warning" => "Une erreur est survenue lors de la l'activation de l'école ".$error_persiste,
            ],

            "find" => [
                "success" => "Ecole(s) trouvée(s) avec succès",
                "nothing" => "Aucune école trouvée pour cet ID",
                "invalid_id" => "Veuillez renseigner un ID de l'école valide",
                "unexists" => "Cette école n'existe pas" 
            ],
        ],

        'medias' => [
            'id_invalid' => "L'ID du média envoyé est invalide",
            'create' => [
                'success' => "Fichier enregistré avec succès",
                "warning" => "Une erreur est survenue lors de la'enregistrement du fichier ".$error_persiste,
            ]
        ],

        'acteurs' => [
            'create' => [
                "sexe_invalid" => "Sexe invalide, doit être M ou F ou Autre",
                "success" => "Acteur créé avec succès",
                "warning" => "Une erreur est survenue lors de la création de l'acteur ".$error_persiste,
            ],

            'update' => [
                "success" => "Acteur modifié avec succès",
                "warning" => "Une erreur est survenue lors de la modification de l'acteur ".$error_persiste,
            ],

            'find' => [
                "nothing" => "Aucun acteur trouvé pour cet ID"
            ]
        ],

        'errors' => [
            '404' => "La route demandée n'existe pas (ou plus)"
        ],

        // Clé de la langue liée aux personnels
        'personnels' => [
            "create" => [
                'success' => "Personnel créé avec succès",
                'warning' => "Une erreur est survenue lors de la création du personnel ".$error_persiste,
                "id_acteur_invalid" => "ID acteur invalide",
                "id_ecole_invalid" => "ID école invalide",
                "matricule_used" => "Ce matricule est déjà utilisé par un autre personnel de cette école",
                "username_used" => "Nom d'utilisateur déjà utilisé par un autre personnel de cette école",
                "already_gerant_sous_module" => "Ce personnel est déjà assigné gérant de ce sous module",
            ],

            'update' => [
                'success' => "Modification du personnel faite avec succès",
                'warning' => "Une erreur est survenue lors de la mofication du personnel ".$error_persiste,
                'desactive' => "Cet personnel a été désactivé, vous ne pouvez pas modifier ses données. Veuillez le réactiver avant de les modifier.",
                'avatar_gerant_success' => "Mise à jour de l'avatar reussi",
                'avatar_gerant_warning' => "Une erreur est survenue lors de la mise à jour de l'avatar",
                'id_media_avatar_gerant_invalid' => "L'ID du média de l'avatar est invalide",
                'password_success' => "Mot de passe modifié avec succès",
                'password_warning' => "Une erreur est survenue lors de la modification du mot de passe"
            ],

            "desactive" => [
                "already_desactived" => "Ce personnel est déjà désactivé",
                "success" => "Personnel désactivé avec succès",
                "warning" => "Une erreur est survenue lors de la désactivation du personnel ".$error_persiste,
            ],

            "active" => [
                "already_actived" => "Ce personnel est déjà activé",
                "success" => "Personnel activé avec succès",
                "warning" => "Une erreur est survenue lors de la l'activation du personnel ".$error_persiste,
            ],

            "find" => [
                "success" => "Personnel(s) trouvé(s) avec succès",
                "nothing" => "Aucun personnel trouvé",
                "invalid_id" => "Veuillez renseigner un ID du personnel valide",
                "invalid_unexists" => "Ce personnel n'est pas enregistré (n'existe pas)",
            ],

            // La langue pour la connexion
            "login" => [
                "invalid_password" => "Mot de passe incorrect",
                "invalid_username" => "Nom d'utilisateur incorrect",
                "invalid_password_or_username" => "Nom d'utilisateur ou mot de passe incorrect",
                "success" => "Connexion reussie",
                "invalid_last_password" => "Ancien mot de passe incorrect",
            ],
        ],

        'default' => [
            "creating" => [
                'success' => "Création effectuée avec succès",
                'warning' => "Une erreur est survenue lors de la création ".$error_persiste,
                'desactive' => "Cet enregistrement a été désactivé, vous ne pouvez pas modifier ses données. Veuillez le réactiver avant de les modifier."
            ],

            'updating' => [
                'success' => "Modification faite avec succès",
                'warning' => "Une erreur est survenue lors de la mofication ".$error_persiste,
            ],

            "desactive" => [
                "already_desactived" => "Cet enregistrement est déjà désactivé",
                "success" => "Désactivation effectuée avec succès",
                "warning" => "Une erreur est survenue lors de la désactivation ".$error_persiste,
            ],

            "active" => [
                "already_actived" => "Cet enregistrement est déjà activé",
                "success" => "Activation effectuée avec succès",
                "warning" => "Une erreur est survenue lors de la l'activation ".$error_persiste,
            ],

            "find" => [
                "success" => "Enregistrement(s) trouvé(s) avec succès",
                "nothing" => "Aucun enregistrement trouvé pour cet ID",
                "invalid_id" => "Veuillez renseigner un ID de l'enregistrement valide"
            ],
        ],

        'modules' => [
            "creating" => [
                'success' => "Module créé avec succès",
                'warning' => "Une erreur est survenue lors de la création du module ".$error_persiste,
                'desactive' => "Ce module a été désactivé, vous ne pouvez pas modifier ses données. Veuillez le réactiver avant de les modifier."
            ],

            'updating' => [
                'success' => "Modification du module faite avec succès",
                'warning' => "Une erreur est survenue lors de la mofication du module ".$error_persiste,
                'desactive' => "Ce module a été désactivé, vous ne pouvez pas modifier ses données. Veuillez le réactiver avant de les modifier."
            ],

            "desactive" => [
                "already_desactived" => "Ce module est déjà désactivé",
                "success" => "Désactivation du module effectuée avec succès",
                "warning" => "Une erreur est survenue lors de la désactivation du module ".$error_persiste,
            ],

            "active" => [
                "already_actived" => "Ce module est déjà activé",
                "success" => "Activation du module effectuée avec succès",
                "warning" => "Une erreur est survenue lors de la l'activation du module ".$error_persiste,
            ],

            "find" => [
                "success" => "Module(s) trouvé(s) avec succès",
                "nothing" => "Aucun module trouvé pour cet ID",
                "invalid_id" => "Veuillez renseigner un ID d'un module valide"
            ],
        ],

        'sous_modules' => [
            "creating" => [
                'success' => "Sous module créé avec succès",
                'warning' => "Une erreur est survenue lors de la création du sous module ".$error_persiste,
                'desactive' => "Ce sous module a été désactivé, vous ne pouvez pas modifier ses données. Veuillez le réactiver avant de les modifier.",
                'module_desactived' => "Vous ne pouvez pas créer un sous module lié à un module désactivé"
            ],

            'updating' => [
                'success' => "Modification du sous module faite avec succès",
                'warning' => "Une erreur est survenue lors de la mofication du sous module ".$error_persiste,
                'module_desactived' => "Vous ne pouvez pas modifier les éléments (sous module) lié à un module désactivé",
                'desactive' => "Ce sous module a été désactivé, vous ne pouvez pas modifier ses données. Veuillez le réactiver avant de les modifier."
            ],

            "desactive" => [
                "already_desactived" => "Ce sous module est déjà désactivé",
                "success" => "Désactivation du sous module effectuée avec succès",
                "warning" => "Une erreur est survenue lors de la désactivation du sous module ".$error_persiste,
            ],

            "active" => [
                "already_actived" => "Ce sous module est déjà activé",
                "success" => "Activation du sous module effectuée avec succès",
                "warning" => "Une erreur est survenue lors de la l'activation du sous module ".$error_persiste,
            ],

            "find" => [
                "success" => "Sous module(s) trouvé(s) avec succès",
                "nothing" => "Aucun sous module trouvé pour cet ID",
                "unsubscribe" => "Vous n'avez pas souscrit à ce sous module",
                "invalid_id" => "Veuillez renseigner un ID d'un sous module valide"
            ],
        ],

        'abonnements' => [
            "creating" => [
                'success' => "Abonnement créé avec succès",
                'warning' => "Une erreur est survenue lors de la création du abonnement ".$error_persiste,
                'desactive' => "Cet abonnement a été désactivé, vous ne pouvez pas modifier ses données. Veuillez le réactiver avant de les modifier.",
                'module_desactived' => "Vous ne pouvez pas lié un abonnement à un module désactivé",
                'ecole_desactived' => "Vous ne pouvez pas lié un abonnement à une ecole désactivée",
            ],

            'updating' => [
                'success' => "Modification du abonnement faite avec succès",
                'warning' => "Une erreur est survenue lors de la mofication du abonnement ".$error_persiste,
                'module_desactived' => "Vous ne pouvez pas modifier les éléments (abonnement) lié à un module désactivé",
                'desactive' => "Ce abonnement a été désactivé, vous ne pouvez pas modifier ses données. Veuillez le réactiver avant de les modifier.",
                'ecole_desactived' => "Vous ne pouvez pas modifier un abonnement lié à une ecole désactivée",
            ],

            "desactive" => [
                "already_desactived" => "Cet abonnement est déjà désactivé",
                "success" => "Désactivation du abonnement effectuée avec succès",
                "warning" => "Une erreur est survenue lors de la désactivation du abonnement ".$error_persiste,
            ],

            "active" => [
                "already_actived" => "Cet abonnement est déjà activé",
                "success" => "Activation du abonnement effectuée avec succès",
                "warning" => "Une erreur est survenue lors de la l'activation du abonnement ".$error_persiste,
            ],

            "find" => [
                "success" => "abonnement(s) trouvé(s) avec succès",
                "nothing" => "Aucun abonnement trouvé pour cet ID",
                "unsubsribe" => "Vous n'avez pas souscrit à cet abonnement",
                "invalid_id" => "Veuillez renseigner un ID d'un abonnement valide",
            ],

            "activate_abonnement" => [
                "success" => "Abonnement activé avec succès",
                "expire_or_noactive" => "Cet abonnement est expiré ou inactif",
                "invalid_id_ecole_abonneent" => "Cette école n'a souscrit à cet abonnement",
                "warning" => "Une erreur est survenue lors de l'activation de l'abonnement ".$error_persiste,
            ]
        ],

        'eleves' => [
            "creating" => [
                'success' => "Inscription élève reussie",
                'warning' => "Une erreur est survenue lors de 'inscription de l'élève ".$error_persiste,
                'already_exists' => "Cet élève semble déjà être enregistré ou matricule déjà utilisé",
                'matricule_used' => "Ce matricule est déjà utilisé par un autre élève"
            ],

            'updating' => [
                'success' => "Modification faite avec succès",
                'warning' => "Une erreur est survenue lors de la mofication ".$error_persiste,
            ],

            "desactive" => [
                "already_desactived" => "Cet élève est déjà désactivé",
                "success" => "Désactivation effectuée avec succès",
                "warning" => "Une erreur est survenue lors de la désactivation ".$error_persiste,
            ],

            "active" => [
                "already_actived" => "Cet élève est déjà activé",
                "success" => "Activation effectuée avec succès",
                "warning" => "Une erreur est survenue lors de la l'activation ".$error_persiste,
            ],

            "find" => [
                "success" => "Elève(s) trouvé(s) avec succès",
                "nothing" => "Aucun élève trouvé pour cet ID",
                "invalid_id" => "Veuillez renseigner un ID de l'élève valide"
            ],

            "delete" => [
                "already_deleted" => "Cet élève est déjà supprimé",
                "success" => "Suppression effectuée avec succès",
                "warning" => "Une erreur est survenue lors de la suppression ".$error_persiste,
            ],

            "restore" => [
                "already_restored" => "Cet élève est déjà restauré",
                "success" => "Restauration effectuée avec succès",
                "warning" => "Une erreur est survenue lors de la restauration ".$error_persiste,
            ],
        ],
    ];