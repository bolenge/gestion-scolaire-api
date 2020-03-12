<?php
    namespace App\Models;

    use Ekolo\Framework\Bootstrap\Model;

    /**
     * Model pour la table admins
     */
    class EcolesModel extends Model
    {
        public function __construct()
        {
            parent::__construct();
            $this->setTable('ecoles');
        }

        /**
         * Trouve toutes les écoles par limit
         * @param int $limit
         * @param int $offset
         * @return  object
         */
        public function findAllEcoles(int $limit = 10, int $offset = 0)
        {
            return $this->findAll([
                'limit' => $limit.' OFFSET '.$offset
            ]);
        }
    }
    