<?php

    namespace App\Repositories;

    use OpenApi\Annotations as OA;
    use Ekolo\Framework\Bootstrap\Model;
    use Ekolo\Framework\Http\Request;
    use Ekolo\Framework\Http\Response;

    /**
     * Repository principal
     */
    trait Repository
    {
        /**
         * L'instance de Ekolo\Framework\Bootstrap\Model
         * @var Model
         */
        protected $model;

        /**
         * Le nom de la table à faire les repos
         * @var string
         */
        protected $table;

        /**
         * Réprésente le __construct de ce trait
         */
        public function traitRepositoryContruct()
        {
            # code...
        }
    }
    
