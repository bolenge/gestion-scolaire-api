<?php

    namespace App\Controllers;

    use Ekolo\Framework\Bootstrap\Controller;
    use Ekolo\Framework\Http\Request;
    use Ekolo\Framework\Http\Response;

    use App\Utils\PersonnelsUtil;
    use App\Repositories\PersonnelsRepository;

    class PersonnelsController extends Controller {

        use PersonnelsUtil;
        use PersonnelsRepository;

        /**
         * Les méthodes considerées comme des __contruct des traits
         */
        protected $traitsContructs = [
            'traitPersonnelsUtilConstruct',
            'traitPersonnelsRepositoryConstruct'
        ];


        /**
         * Permet de créer un nouveau personnel d'une école
         * 
         * @OA\Post(
         *      path="/personnels/createPersonnel",
         *      tags={"Personnels"},
         *      @OA\RequestBody(ref="#/components/requestBodies/createPersonnelRequest"),
         *      @OA\Response(
         *          response="200",
         *          ref="#/components/responses/SuccessResponse"
         *      ),
         *      @OA\Response(
         *          response="404",
         *          ref="#/components/responses/NotFoundResponse"
         *      )
         * )
         */
        public function createPersonnel(Request $request, Response $response)
        {
            if ($request->validator($this->rulesCreating)) {

                if (!$this->model->exists('id', $request->body()->id_acteur(), 'acteurs')) {
                    \session()->set('errors',
                    !session()->has('errors') ? [] : [
                        'id_acteur' => $this->locales['create']['id_acteur_invalid']
                    ]);
                }

                $personnel = $this->model->findOne([
                    'cond' => 'matricule="'.$request->body()->matricule().
                        '" AND id_ecole='.$request->body()->id_ecole()
                ], 'personnels');

                if (!empty($personnel)) {
                    \session()->set('errors',
                    !session()->has('errors') ? [] : [
                        'matricule' => $this->locales['create']['matricule_used']
                    ]);
                }

                if (!$this->model->exists('id', $request->body()->id_ecole(), 'ecoles')) {
                    \session()->set('errors',
                    !session()->has('errors') ? [] : [
                        'id_ecole' => $this->locales['create']['id_ecole_invalid']
                    ]);
                }

                if (!session()->has('errors')) {
                    if (!empty($personnel = $this->save($request, $response))) {
                        $this->objetRetour['success'] = true;
                        $this->objetRetour['message'] = $this->locales['create']['success'];
                        $this->objetRetour['results'] = $admin;
                    }else {
                        $this->objetRetour['message'] = $this->locales['create']['warning'];
                        session()->set('errors', [
                            'warning' => $this->locales['create']['warning']
                        ]);
                    }
                }
            }

            $this->trackErrors();
            $response->json($this->objetRetour);
        }

        /**
         * Permet de modifier les données d'un admin
         * 
         * @OA\Put(
         *      path="/personnels/updatePersonnel/{id}",
         *      tags={"Personnels"},
         *      @OA\Parameter(ref="#/components/parameters/id"),
         *      @OA\RequestBody(ref="#/components/requestBodies/createPersonnelRequest"),
         *      @OA\Response(
         *          response="200",
         *          ref="#/components/responses/SuccessResponse"
         *      ),
         *      @OA\Response(
         *          response="404",
         *          ref="#/components/responses/NotFoundResponse"
         *      )
         * )
         */
        public function updatePersonnel(Request $request, Response $response)
        {
            $request->body()->set('id', $request->params()->get('id'));

            if ($request->validator($this->rulesCreating)) {

                $personnel = $this->model->findOneById($request->body('id'), 'personnels');

                if (!empty($personnel)) {
                    if (!$this->model->exists('id', $request->body()->id_acteur(), 'acteurs')) {
                        \session()->set('errors',
                        !session()->has('errors') ? [] : [
                            'id_acteur' => $this->locales['create']['id_acteur_invalid']
                        ]);
                    }
    
                    if ($this->model->exists('matricule', $personnel->matricule, 'personnels') && $personnel->id_ecole != $request->body()->id_ecole()) {
                        \session()->set('errors',
                        !session()->has('errors') ? [] : [
                            'matricule' => $this->locales['create']['matricule_used']
                        ]);
                    }
    
                    if (!$this->model->exists('id', $request->body()->id_ecole(), 'ecoles')) {
                        \session()->set('errors',
                        !session()->has('errors') ? [] : [
                            'id_ecole' => $this->locales['create']['id_ecole_invalid']
                        ]);
                    }
    
                    if (!session()->has('errors')) {
                        if (!empty($personnel = $this->save($request, $response))) {
                            $this->objetRetour['success'] = true;
                            $this->objetRetour['message'] = $this->locales['update']['success'];
                            $this->objetRetour['results'] = $personnel;
                        }else {
                            $this->objetRetour['message'] = $this->locales['update']['warning'];
                            session()->set('errors', [
                                'warning' => $this->locales['update']['warning']
                            ]);
                        }
                    }
                }
            }

            $this->trackErrors();
            $response->json($this->objetRetour);
        }

        /**
         * Permet de désactiver un personnel
         * 
         * @OA\Delete(
         *      path="/personnels/desactivePersonnel/{id}",
         *      tags={"Personnels"},
         *      @OA\Parameter(ref="#/components/parameters/id"),
         *      @OA\Response(
         *          response="200",
         *          ref="#/components/responses/SuccessResponse"
         *      ),
         *      @OA\Response(
         *          response="404",
         *          ref="#/components/responses/NotFoundResponse"
         *      )
         * )
         */
        public function desactivePersonnel(Request $request, Response $response)
        {   
            $request->body()->set('id', $request->params()->get('id'));
            
            if ($request->validator($this->rulesCreating)) {
                if (!empty($personnel = $this->model->findOneById($request->body()->get('id')))) {
                    
                    if ($personnel->flag == "0") {
                        session()->set('errors', [
                            'warning' => $this->locales['desactive']['already_desactived']
                        ]);
                    }else {
                        $result = $this->model->update([
                            'id' => $request->body()->get('id'),
                            'flag' => "0"
                        ]);

                        if ($result) {
                            $this->objetRetour['success'] = true;
                            $this->objetRetour['message'] = $this->locales['desactive']['success'];
                            $this->objetRetour['results'] = $result;
                        }else {
                            session()->set('errors', [
                                'warning' => $this->locales['desactive']['warning']
                            ]);
                        }
                    }
                }else {
                    \session()->set('errors', [
                        'warning' => $this->locales['find']['nothing']
                    ]);
                }
            }

            $this->trackErrors();
            $response->json($this->objetRetour);
        }

        /**
         * Permet de d'activer un personnel
         * 
         * @OA\Put(
         *      path="/personnels/activePersonnel/{id}",
         *      tags={"Personnels"},
         *      @OA\Parameter(ref="#/components/parameters/id"),
         *      @OA\Response(
         *          response="200",
         *          ref="#/components/responses/SuccessResponse"
         *      ),
         *      @OA\Response(
         *          response="404",
         *          ref="#/components/responses/NotFoundResponse"
         *      )
         * )
         */
        public function activePersonnel(Request $request, Response $response)
        {   
            $request->body()->set('id', $request->params()->get('id'));
            
            if ($request->validator($this->rulesCreating)) {
                if (!empty($admin = $this->model->findOneById($request->body()->get('id')))) {
                    
                    if ($admin->flag == "1") {
                        session()->set('errors', [
                            'warning' => $this->locales['active']['already_actived']
                        ]);
                    }else {
                        $result = $this->model->update([
                            'id' => $request->body()->get('id'),
                            'flag' => "1"
                        ]);

                        if ($result) {
                            $admin->flag = "1";
                            $this->objetRetour['success'] = true;
                            $this->objetRetour['message'] = $this->locales['active']['success'];
                            $this->objetRetour['results'] = $admin;
                        }else {
                            session()->set('errors', [
                                'warning' => $this->locales['active']['warning']
                            ]);
                        }
                    }
                }else {
                    \session()->set('errors', [
                        'warning' => $this->locales['find']['nothing']
                    ]);
                }
            }

            $this->trackErrors();
            $response->json($this->objetRetour);
        }
    }