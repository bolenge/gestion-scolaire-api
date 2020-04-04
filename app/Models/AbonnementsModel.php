<?php
    namespace App\Models;

    use Ekolo\Framework\Bootstrap\Model;

    /**
     * Model pour les abonnements
     */
    class AbonnementsModel extends Model
    {
        public function __construct()
        {
            parent::__construct();
            $this->setTable('abonnements');
        }

        /**
         * Trouve toutes les abonnements par limit
         * @param int $limit
         * @param int $offset
         * @return  object
         */
        public function findAllAbonnements(int $limit = 10, int $offset = 0)
        {
            return $this->findAll([
                'limit' => $limit.' OFFSET '.$offset
            ]);
        }

        /**
         * Permet d'activer l'abonnement d'une école
         * @param int $id_abonnement L'ID de l'abonnement
         * @param int $delai Le délai (durée) de l'abonnement
         * @return bool
         */
        public function activateAbonnement(int $id_abonnement, int $delai)
        {
            $sql = 'UPDATE '.$this->table.' SET date_debut=NOW(),date_fin=DATE_ADD(NOW(), INTERVAL '.$delai.' DAY) WHERE id=:id';

            $q = $this->db->prepare($sql);

            return $q->execute([
                'id' => (int) $id_abonnement
            ]);
        }

        public function expireAbonnements()
        {
            $sql = 'UPDATE '.$this->table.' SET flag="0" WHERE ';
        }
    }
    