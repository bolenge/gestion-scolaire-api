<?php
    namespace App\Models;

    use Ekolo\Framework\Bootstrap\Model;

    /**
     * Model pour la table personnels gérants
     */
    class PersonnelsGerantsModel extends Model
    {
        public function __construct()
        {
            parent::__construct();
            $this->setTable('personnels_gerants');
        }

        /**
         * Trouve la liste des personnels gérants
         * @param int $limit
         * @param int $offset
         * @return  object
         */
        public function findAllPersonnelsGerants(int $limit = 10, int $offset = 0)
        {
            return $this->findAll([
                'limit' => $limit.' OFFSET '.$offset
            ]);
        }
    }
    