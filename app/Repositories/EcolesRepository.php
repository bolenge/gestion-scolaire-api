<?php

    namespace App\Repositories;

    use OpenApi\Annotations as OA;
    use Ekolo\Framework\Http\Request;
    use Ekolo\Framework\Http\Response;

    use App\Repositories\Repository;
    use App\Models\EcolesModel;

    /**
     * Repository pour les écoles
     */
    trait EcolesRepository
    {
        use Repository;

        /**
         * Réprésente le __construct de ce trait
         */
        public function traitEcolesRepositoryContruct()
        {
            $this->model = new EcolesModel;
            $this->table = 'ecoles';
        }

        /**
         * Permet de savegarder les informations d'une école
         * @return mixed
         */
        public function save(Request $request, Response $response)
        {
            $data = [
                'nom' => $request->body()->nom(),
                'email' => $request->body()->email(),
                'website' => $request->body()->website(),
                'localite' => $request->body()->localite(),
                'telephone' => $request->body()->telephone(),
                'num_agrement' => $request->body()->num_agrement()
            ];

            if (!empty($request->body()->id())) {
                $data['id'] = $request->body()->id();
            }

            if (!empty($request->body()->id_media_logo())) {
                $data['id_media_logo'] = $request->body()->id_media_logo();
            }

            return $this->model->save($data, $this->table);
        }
    }
    
