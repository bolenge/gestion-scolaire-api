<?php

    namespace App\Repositories;

    use OpenApi\Annotations as OA;
    use Ekolo\Framework\Http\Request;
    use Ekolo\Framework\Http\Response;

    use App\Repositories\Repository;
    use App\Models\AdminsModel;

    /**
     * Repository pour les admins
     */
    trait AdminsRepository
    {
        use Repository;

        /**
         * Réprésente le __construct de ce trait
         */
        public function traitAdminsRepositoryContruct()
        {
            $this->model = new AdminsModel;
            $this->table = 'admins';
        }

        /**
         * Permet de savegarder les informations d'un admin
         * @param Request $request instance de Ekolo\Framework\Http\Request
         * @param Response $response instance de Ekolo\Framework\Http\Response
         * @return mixed
         */
        public function save(Request $request, Response $response)
        {
            $data = [
                'role' => $request->body()->role(),
                'username' => $request->body()->username(),
                'password' => bcrypt_hash_password($request->body()->password()),
                'id_acteur' => $request->body()->id_acteur()
            ];

            if (!empty($request->body()->id())) {
                $data['id'] = $request->body()->id();
            }

            return $this->model->save($data, $this->table);
        }
    }
    
