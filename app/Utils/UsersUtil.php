<?php

    namespace App\Utils;

    use OpenApi\Annotations as OA;
    use App\Utils\Util;

    
    trait UsersUtil
    {
        use Util;

        /**
         * Les règles sur des requêtes qu'on peut bien lancer
         * @var array
         */
        protected $rules = [
            'nom' => 'required|min:3|max:100|alpha',
            'postnom' => 'min:3|max:100|alpha',
            'prenom' => 'required|min:3|max:100|alpha',
            'sexe' => 'alpha:1',
            'etat_civil' => 'min:2|max:100|alpha',
            'telephone' => ''
        ];
    }
    
