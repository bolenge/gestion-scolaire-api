<?php
    /**
     * La localisation (langue) française de l'application
     */

    return [
        'admins' => [
            'login' => [
                'username_invalid' => 'Ce compte n\'existe pas',
                'password_invalid' => "Mot de passe incorrect",
                'success' => "Admin trouvé avec succès",
                'username_or_password_invalid' => "Nom d'utilisateur ou Mot de passe incorrect"
            ]
        ],

        'ecoles' => [
            'create' => [
                'success' => "L'école est créée avec succès",
                'warning' => "Une erreur est survenue lors de la création de l'école (Si cette erreur persiste veuillez contacter le service de développement UHTEC)",
                'num_agrement_in_used' => "le numéro d'agrément est déjà utilisé pour une autre école",
                'id_media_logo_invalid' => "ID du média du logo est invalide (ou logo invalide)"
            ]
        ],

        'medias' => [
            'id_invalid' => "L'ID du média envoyé est invalide"
        ],

        'errors' => [
            '404' => "La route demandée n'existe pas (ou plus)"
        ]
    ];