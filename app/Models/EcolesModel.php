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
    }
    