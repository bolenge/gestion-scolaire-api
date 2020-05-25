<?php
    namespace App\Models;

    use Ekolo\Framework\Bootstrap\Model;

    /**
     * Model pour le tracking (traquage) des personnels
     */
    class TrackingPersonnelsModel extends Model
    {
        public function __construct()
        {
            parent::__construct();
            $this->setTable('tracking_personnels');
        }

        /**
         * Permet de créer un nouveau traquage
         * @param array $data Les données traquées
         * @return mixed
         */
        public function create(array $data)
        {
            return $this->model->save($data, $this->table);
        }
    }
    