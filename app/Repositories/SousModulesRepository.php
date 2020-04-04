<?php

    namespace App\Repositories;

    use OpenApi\Annotations as OA;
    use Ekolo\Framework\Http\Request;
    use Ekolo\Framework\Http\Response;

    use App\Repositories\Repository;
    use App\Models\SousModulesModel;

    /**
     * Repository pour les sous modules
     */
    trait SousModulesRepository
    {
        use Repository;

        /**
         * Réprésente le __construct de ce trait
         */
        public function traitSousModulesRepositoryConstruct()
        {
            $this->model = new SousModulesModel;
            $this->table = 'sous_modules';
        }

        /**
         * Permet de savegarder les informations d'un module
         * @return mixed
         */
        public function save(Request $request, Response $response)
        {
            $data = [
                'intitule' => $request->body()->intitule(),
                'description' => $request->body()->description(),
                'id_module' => $request->body()->id_module()
            ];

            if (!empty($request->body()->id())) {
                $data['id'] = $request->body()->id();
            }

            return $this->model->save($data, $this->table);
        }
    }