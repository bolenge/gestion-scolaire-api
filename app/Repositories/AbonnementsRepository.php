<?php

    namespace App\Repositories;

    use OpenApi\Annotations as OA;
    use Ekolo\Framework\Http\Request;
    use Ekolo\Framework\Http\Response;

    use App\Repositories\Repository;
    use App\Models\AbonnementsModel;

    /**
     * Repository pour les abonnements
     */
    trait AbonnementsRepository
    {
        use Repository;

        /**
         * Réprésente le __construct de ce trait
         */
        public function traitabonnementsRepositoryConstruct()
        {
            $this->model = new AbonnementsModel;
            $this->table = 'abonnements';
        }

        /**
         * Permet de savegarder les informations d'un abonnement
         * @return mixed
         */
        public function save(Request $request, Response $response)
        {
            $data = [
                'id_module' => $request->body()->id_module(),
                'id_ecole' => $request->body()->id_ecole(),
                'montant_paye' => $request->body()->montant_paye(),
                'delai' => $request->body()->delai()
            ];

            if (!empty($request->body()->id())) {
                $data['id'] = $request->body()->id();
            }

            return $this->model->save($data, $this->table);
        }
    }