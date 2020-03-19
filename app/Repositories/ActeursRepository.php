<?php

    namespace App\Repositories;

    use OpenApi\Annotations as OA;
    use Ekolo\Framework\Http\Request;
    use Ekolo\Framework\Http\Response;

    use App\Repositories\Repository;
    use App\Models\ActeursModel;

    /**
     * Repository pour les admins
     */
    trait ActeursRepository
    {
        use Repository;

        /**
         * Réprésente le __construct de ce trait
         */
        public function traitActeursRepositoryContruct()
        {
            $this->model = new ActeursModel;
            $this->table = 'acteurs';
        }

        /**
         * Permet de savegarder les informations d'un acteur
         * @param Request $request instance de Ekolo\Framework\Http\Request
         * @param Response $response instance de Ekolo\Framework\Http\Response
         * @return mixed
         */
        public function save(Request $request, Response $response)
        {
            $data = [
                'nom' => $request->body()->nom(),
                'sexe' => $request->body()->sexe(),
                'email' => $request->body()->email(),
                'prenom' => $request->body()->prenom(),
                'postnom' => $request->body()->postnom(),
                'telephone' => $request->body()->telephone(),
                'etat_civil' => $request->body()->etat_civil()
            ];

            if (!empty($request->body()->id())) {
                $data['id'] = $request->body()->id();
            }
            
            if (!empty($request->body()->id_adresse())) {
                $data['id_adresse'] = $request->body()->id_adresse();
            }

            if (!empty($request->body()->id_media_avatar())) {
                $data['id_media_avatar'] = $request->body()->id_media_avatar();
            }

            return $this->model->save($data, $this->table);
        }
    }
    
