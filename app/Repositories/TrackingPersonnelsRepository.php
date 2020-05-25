<?php

    namespace App\Repositories;

    use OpenApi\Annotations as OA;
    use Ekolo\Framework\Http\Request;
    use Ekolo\Framework\Http\Response;

    use App\Repositories\Repository;
    use App\Models\TrackingPersonnelsModel;

    /**
     * Repository pour les admins
     */
    trait TrackingPersonnelsRepository
    {
        use Repository;

        /**
         * Réprésente le __construct de ce trait
         */
        public function traitTrackingPersonnelsRepositoryConstruct()
        {
            $this->model = new TrackingPersonnelsModel;
            $this->table = 'tracking_personnels';
        }
    }
    
