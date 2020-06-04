<?php

    namespace App\Repositories;

    use OpenApi\Annotations as OA;
    use Ekolo\Framework\Http\Request;
    use Ekolo\Framework\Http\Response;

    use App\Repositories\Repository;
    use App\Models\ElevesModel;

    /**
     * Repository pour les eleves
     */
    trait ElevesRepository
    {
        use Repository;

        /**
         * Réprésente le __construct de ce trait
         */
        public function traitElevesRepositoryConstruct()
        {
            $this->model = new ElevesModel;
            $this->table = 'eleves';
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
                'matricule' => $request->body()->matricule(),
                'id_ecole' => $request->body()->id_ecole(),
                'id_acteur' => $request->body()->id_acteur()
            ];

            if (!empty($request->body()->id())) {
                $data['id'] = $request->body()->id();
            }

            return $this->model->save($data, $this->table);
        }
    }
    
