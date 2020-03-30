<?php

    namespace App\Repositories;

    use OpenApi\Annotations as OA;
    use Ekolo\Framework\Http\Request;
    use Ekolo\Framework\Http\Response;

    use App\Repositories\Repository;
    use App\Models\ModulesModel;

    /**
     * Repository pour les écoles
     */
    trait ModulesRepository
    {
        use Repository;

        /**
         * Réprésente le __construct de ce trait
         */
        public function traitModulesRepositoryConstruct()
        {
            $this->model = new ModulesModel;
            $this->table = 'modules';
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
                'tarif' => $request->body()->tarif(),
                'nbre_jours' => $request->body()->nbre_jours()
            ];

            if (!empty($request->body()->id())) {
                $data['id'] = $request->body()->id();
            }

            return $this->model->save($data, $this->table);
        }
    }