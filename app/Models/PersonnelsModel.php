<?php
    namespace App\Models;

    use Ekolo\Framework\Bootstrap\Model;

    /**
     * Model pour la table personnels
     */
    class PersonnelsModel extends Model
    {
        public function __construct()
        {
            parent::__construct();
            $this->setTable('personnels');
        }

        /**
         * Trouve la liste des personnels
         * @param int $limit
         * @param int $offset
         * @return  object
         */
        public function findAllPersonnels(int $limit = 10, int $offset = 0)
        {
            return $this->findAll([
                'limit' => $limit.' OFFSET '.$offset
            ]);
        }
    }
    