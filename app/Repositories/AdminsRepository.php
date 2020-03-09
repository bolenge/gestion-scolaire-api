<?php

    namespace App\Repositories;

    use OpenApi\Annotations as OA;
    use Ekolo\Framework\Http\Request;
    use Ekolo\Framework\Http\Response;

    use App\Repositories\Repository;
    use App\Models\AdminsModel;

    /**
     * Repository pour les admins
     */
    trait AdminsRepository
    {
        use Repository;

        /**
         * Réprésente le __construct de ce trait
         */
        public function traitAdminsRepositoryContruct()
        {
            $this->model = new AdminsModel;
            $this->table = 'admins';
        }
    }
    
