<?php

    namespace App\Repositories;

    use OpenApi\Annotations as OA;
    use Ekolo\Framework\Http\Request;
    use Ekolo\Framework\Http\Response;

    use App\Repositories\Repository;
    use App\Models\PersonnelsGerantsModel;

    /**
     * Repository pour les personnels gérants
     */
    trait PersonnelsGerantsRepository
    {
        use Repository;

        /**
         * Réprésente le __construct de ce trait
         */
        public function traitPersonnelsGerantsRepositoryConstruct()
        {
            $this->model = new PersonnelsGerantsModel;
            $this->table = 'personnels_gerants';
        }

        /**
         * Permet de faire la sauvegarde
         * @param Request $request instance de Ekolo\Framework\Http\Request
         * @param Response $response instance de Ekolo\Framework\Http\Response
         * @return mixed
         */
        public function save(Request $request, Response $response)
        {
            $data = [
                'id_ecole' => $request->body()->id_ecole(),
                'id_personnel' => $request->body()->id_personnel(),
                'id_abonnement' => $request->body()->id_abonnement(),
                'id_sous_module' => $request->body()->id_sous_module(),
                'role' => $request->body()->role(),
                'username' => $request->body()->username(),
                'password' => bcrypt_hash_password($request->body()->password())
            ];

            if (!empty($request->body()->id())) {
                $data['id'] = $request->body()->id();
            }

            return $this->model->save($data, $this->table);
        }
    }
    
