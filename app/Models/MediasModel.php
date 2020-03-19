<?php
    namespace App\Models;

    use Ekolo\Framework\Bootstrap\Model;

    /**
     * Model pour la table medias
     */
    class MediasModel extends Model
    {
        public function __construct()
        {
            parent::__construct();
            $this->setTable('medias');
        }
    }
    