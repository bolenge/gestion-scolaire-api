<?php
    namespace App\Models;

    use Ekolo\Framework\Bootstrap\Model;

    /**
     * Model pour la table acteurs
     */
    class ActeursModel extends Model
    {
        public function __construct()
        {
            parent::__construct();
            $this->setTable('acteurs');
        }
    }
    