<?php

    namespace App\Repositories;

    use OpenApi\Annotations as OA;
    use Ekolo\Framework\Http\Request;
    use Ekolo\Framework\Http\Response;

    use App\Repositories\Repository;
    use App\Models\MediasModel;

    /**
     * Repository pour les admins
     */
    trait MediasRepository
    {
        use Repository;

        /**
         * Réprésente le __construct de ce trait
         */
        public function traitMediasRepositoryContruct()
        {
            $this->model = new MediasModel;
            $this->table = 'medias';
        }

        /**
         * Permet de savegarder les informations d'un acteur
         * @param Request $request instance de Ekolo\Framework\Http\Request
         * @param Response $response instance de Ekolo\Framework\Http\Response
         * @return mixed
         */
        public function save(Request $request, Response $response)
        {
            
        }
    }
    
