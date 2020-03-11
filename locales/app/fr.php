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

            "create" => [
                "email_used" => "Adresse email déjà utilisé pour un autre compte admin",
                "role_invalid" => "Rôle de l'admin est invalide",
                "username_used" => "Nom d'utilisateur déjà utilisé pour un autre compte",
                'success' => "Admin créé avec succès",
                'warning' => "Une erreur est survenue lors de la création de l'admin ".$error_persiste,
                "id_acteur_invalid" => "ID acteur de données de l'admin est invalide"
            ],

            "find" => [
                "success" => "Admin trouvé avec succès",
                "nothing" => "Aucun admin trouvé pour cet ID",
                "invalid_id" => "Veuillez renseigner un ID de l'admin valide"
            ],

            'update' => [
                'success' => "Modification de l'admin faite avec succès",
                'warning' => "Une erreur est survenue lors de la mofication de l'admin ".$error_persiste,
                'desactive' => "Cet admin a été désactivé, vous ne pouvez pas modifier ses données. Veuillez le réactiver avant de les modifier."
            ]
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
            ]
        ],

        'medias' => [
            'id_invalid' => "L'ID du média envoyé est invalide"
        ],

        'acteurs' => [
            'create' => [
                "sexe_invalid" => "Sexe invalide, doit être M ou F ou Autre",
                "success" => "Acteur créé avec succès",
                "warning" => "Une erreur est survenue lors de la l'activation de l'acteur ".$error_persiste,
            ]
        ],

        'errors' => [
            '404' => "La route demandée n'existe pas (ou plus)"
        ]
    ];