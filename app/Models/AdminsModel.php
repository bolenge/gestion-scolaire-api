<?php
    namespace App\Models;

    use Ekolo\Framework\Bootstrap\Model;

    /**
     * Model pour la table admins
     */
    class AdminsModel extends Model
    {
        public function __construct()
        {
            parent::__construct();
            $this->setTable('admins');
        }

        /**
         * Trouve la liste des admins
         * @param int $limit
         * @param int $offset
         * @return  object
         */
        public function findAllAdmins(int $limit = 10, int $offset = 0)
        {
            return $this->findAll([
                'limit' => $limit.' OFFSET '.$offset
            ]);
        }
    }
    