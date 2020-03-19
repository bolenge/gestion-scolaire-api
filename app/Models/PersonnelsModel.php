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
    }
    