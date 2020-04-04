<?php
    namespace App\Models;

    use Ekolo\Framework\Bootstrap\Model;

    /**
     * Model pour les sous modules
     */
    class SousModulesModel extends Model
    {
        public function __construct()
        {
            parent::__construct();
            $this->setTable('sous_modules');
        }

        /**
         * Trouve toutes les sous modules par limit
         * @param int $limit
         * @param int $offset
         * @return  object
         */
        public function findAllModules(int $limit = 10, int $offset = 0)
        {
            return $this->findAll([
                'limit' => $limit.' OFFSET '.$offset
            ]);
        }
    }
    