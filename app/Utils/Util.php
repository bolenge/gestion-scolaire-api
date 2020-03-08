<?php

    namespace App\Utils;

    use OpenApi\Annotations as OA;
    use Ekolo\Framework\Bootstrap\Model;

    /**
     * Util principal
     */
    trait Util
    {
        /**
         * Le locale des fonctionnalités d'un module
         * @var array
         */
        protected $locales;

        /**
         * L'objet dont on renvoi après qu'une requête est lancée
         * 
         * @OA\Schema(
         *      schema="objetRetour",
         *      description="Objet retour de résultats uax requêtes",
         *      @OA\Property(type="boolean", property="success"),
         *      @OA\Property(type="string", property="message"),
         *      @OA\Property(type="object", property="results")
         * )
         */
        protected $objetRetour = [
            'success' => false,
            'message' => '',
            'errors' => '',
            'results' => null
        ];

        /**
         * Réprésente le __construct de ce trait
         */
        public function utilConstruct()
        {
            // debug("Le __contruct du trait est lancé");
        }
    }
    
