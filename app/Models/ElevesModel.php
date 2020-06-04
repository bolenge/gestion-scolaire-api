<?php
    namespace App\Models;

    use Ekolo\Framework\Bootstrap\Model;

    /**
     * Model pour la table eleves
     */
    class ElevesModel extends Model
    {
        public function __construct()
        {
            parent::__construct();
            $this->setTable('eleves');
        }

        /**
         * Trouve la liste des eleves
         * @param int $limit
         * @param int $offset
         * @return  object
         */
        public function findAllEleves(int $limit = 10, int $offset = 0)
        {
            return $this->findAll([
                'limit' => $limit.' OFFSET '.$offset
            ]);
        }
    }
    