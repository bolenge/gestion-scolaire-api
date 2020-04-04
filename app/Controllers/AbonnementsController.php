<?php

    namespace App\Controllers;

    use OpenApi\Annotations as OA;

    use Ekolo\Framework\Bootstrap\Controller;
    use Ekolo\Framework\Http\Request;
    use Ekolo\Framework\Http\Response;
    
    use App\Utils\AbonnementsUtil;
    use App\Repositories\AbonnementsRepository;

    /**
     * Controlleur pour les abonnements
     */
    class AbonnementsController extends Controller {

        use AbonnementsUtil;
        use AbonnementsRepository;

        /**
         * Les méthodes considerées comme des __contruct des traits
         */
        protected $traitsContructs = [
            'traitAbonnementsUtilConstruct',
            'traitAbonnementsRepositoryConstruct'
        ];

        /**
         * Permet de créer un nouveau abonnement
         * 
         * @OA\Post(
         *      path="/abonnements/createAbonnement",
         *      tags={"Abonnements"},
         *      security={"bearer"},
         *      @OA\RequestBody(ref="#/components/requestBodies/abonnementRequestBody"),
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
        public function createAbonnement(Request $request, Response $response)
        {
            if ($request->validator($this->rules)) {

                $this->trackErrorsModuleAndEcole($request, $response);

                if (empty(session()->get('errors'))) {
                    if (!empty($abonnement = $this->save($request, $response))) {
                        $this->objetRetour['success'] = true;
                        $this->objetRetour['message'] = $this->locales['creating']['success'];
                        $this->objetRetour['results'] = $abonnement;
                    }else {
                        $this->objetRetour['message'] = $this->locales['creating']['warning'];
                        session()->set('errors', [
                            'warning' => $this->locales['creating']['warning']
                        ]);
                    }
                }
            }

            $this->trackErrors();
            $response->json($this->objetRetour);
        }

        /**
         * Permet de modifier les données d'un abonnement
         * 
         * @OA\Put(
         *      path="/abonnements/updateAbonnement/{id}",
         *      tags={"Abonnements"},
         *      security={"bearer"},
         *      @OA\Parameter(ref="#/components/parameters/id"),
         *      @OA\RequestBody(ref="#/components/requestBodies/abonnementRequestBody"),
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
        public function updateAbonnement(Request $request, Response $response)
        {   
            $request->body()->set('id', $request->params()->get('id'));
            
            if ($request->validator($this->rules)) {
                $abonnement = $this->model->findOne([
                    'cond' => 'id='.$request->body()->id()
                ]);

                if (!empty($abonnement)) {
                    if ($abonnement->flag == "0") {
                        session()->set('errors', [
                            'warning' => $this->locales['updating']['desactive']
                        ]);
                    }else {
                        $this->trackErrorsModuleAndEcole($request, $response);

                        if (!session()->has('errors')) {
                            if (!empty($abonnement = $this->save($request, $response))) {
                                $this->objetRetour['success'] = true;
                                $this->objetRetour['message'] = $this->locales['updating']['success'];
                                $this->objetRetour['results'] = $abonnement;
                            }else {
                                $this->objetRetour['message'] = $this->locales['updating']['warning'];
                                session()->set('errors', [
                                    'warning' => $this->locales['updating']['warning']
                                ]);
                            }
                        }
                    }
                }else {
                    \session()->set('errors', [
                        'warning' => $this->locales['verify']['empty']
                    ]);
                }
            }

            $this->trackErrors();
            $response->json($this->objetRetour);
        }

        /**
         * Permet de d'activer un abonnement
         * 
         * @OA\Put(
         *      path="/abonnements/activeAbonnement/{id}",
         *      tags={"Abonnements"},
         *      security={"bearer"},
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
        public function activeAbonnement(Request $request, Response $response)
        {   
            $request->body()->set('id', $request->params()->get('id'));
            
            if ($request->validator($this->rules)) {
                if (!empty($abonnement = $this->model->findOneById($request->body()->get('id')))) {
                    
                    if ($abonnement->flag == "1") {
                        session()->set('errors', [
                            'warning' => $this->locales['active']['already_actived']
                        ]);
                    }else {
                        $result = $this->model->update([
                            'id' => $request->body()->get('id'),
                            'flag' => "1"
                        ]);

                        if ($result) {
                            $abonnement->flag = "1";
                            $this->objetRetour['success'] = true;
                            $this->objetRetour['message'] = $this->locales['active']['success'];
                            $this->objetRetour['results'] = $abonnement;
                        }else {
                            session()->set('errors', [
                                'warning' => $this->locales['active']['warning']
                            ]);
                        }
                    }
                }else {
                    \session()->set('errors', [
                        'warning' => $this->locales['verify']['empty']
                    ]);
                }
            }

            $this->trackErrors();
            $response->json($this->objetRetour);
        }

        /**
         * Permet de désactiver un abonnement
         * 
         * @OA\Delete(
         *      path="/abonnements/desactiveAbonnement/{id}",
         *      tags={"Abonnements"},
         *      security={"bearer"},
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
        public function desactiveAbonnement(Request $request, Response $response)
        {   
            $request->body()->set('id', $request->params()->get('id'));
            
            if ($request->validator($this->rules)) {
                if (!empty($abonnement = $this->model->findOneById($request->body()->get('id')))) {
                    
                    if ($abonnement->flag == "0") {
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
                        'warning' => $this->locales['verify']['empty']
                    ]);
                }
            }

            $this->trackErrors();

            $response->json($this->objetRetour);
        }

        /**
         * Renvoi les informations d'un abonnement
         * 
         * @OA\Get(
         *      path="/abonnements/getAbonnementById/{id}",
         *      tags={"Abonnements"},
         *      security={"bearer"},
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
        public function getAbonnementById(Request $request, Response $response)
        {
            if ($request->params()->has('id') && \is_int_valid($request->params()->get('id'))) {
                $abonnement = current($this->model->findById($request->params()->get('id')));

                if (!empty($abonnement)) {
                    $this->objetRetour['success'] = true;
                    $this->objetRetour['message'] = $this->locales['find']['success'];
                    $this->objetRetour['results'] = $abonnement;
                }else {
                    \session('errors', [
                        'warning' => $this->locales['find']['nothing']
                    ]);
                }
            }else {
                \session('errors', [
                    'warning' => $this->locales['find']['invalid_id']
                ]);
            }

            $this->trackErrors();
            $response->json($this->objetRetour);
        }

        /**
         * Renvoi les abonnements par limite
         * 
         * @OA\Get(
         *      path="/abonnements/getListAbonnements/{limit}/{offset}",
         *      tags={"Abonnements"},
         *      security={"bearer"},
         *      @OA\Parameter(ref="#/components/parameters/limit"),
         *      @OA\Parameter(ref="#/components/parameters/offset"),
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
        public function getListAbonnements(Request $request, Response $response)
        {
            $limit  = \is_int_valid($request->params()->get('limit')) ? $request->params()->get('limit') : 10;
            $offset = $request->params()->has('offset') ? (int) $request->params()->get('offset') : 0;

            $abonnements = $this->model->findAllAbonnements($limit, $offset);

            if (!empty($abonnements)) {
                $this->objetRetour['success'] = true;
                $this->objetRetour['message'] = count($abonnements).' '.$this->locales['find']['success'];
                $this->objetRetour['results'] = $abonnements;
            }else {
                \session('errors', [
                    'warning' => $this->locales['find']['nothing']
                ]);
            }

            $this->trackErrors();
            $response->json($this->objetRetour);
        }

        /**
         * Permet de d'activer un abonnement
         * 
         * @OA\Put(
         *      path="/abonnements/beginEcoleAbonnement/{id}/{id_ecole}",
         *      tags={"Abonnements"},
         *      security={"bearer"},
         *      @OA\Parameter(ref="#/components/parameters/id", description="ID de l'abonnement"),
         *      @OA\Parameter(ref="#/components/parameters/id_ecole"),
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
        public function beginEcoleAbonnement(Request $request, Response $response)
        {   
            $request->body()->set('id', $request->params()->get('id'));
            $request->body()->set('id_ecole', $request->params()->get('id_ecole'));
            
            if ($request->validator($this->rules)) {
                if (!empty($abonnement = $this->model->findOneById($request->body()->get('id')))) {
                    if ($abonnement->flag == "1") {
                        if ($abonnement->id_ecole === $request->body()->id_ecole()) {
                            $delai = (int) $abonnement->delai;
                            $id_abonnement = (int) $request->body()->id();
                            $result = $this->model->activateAbonnement($id_abonnement, $delai);
    
                            if ($result) {
                                $abonnement = $this->model->findOneById($request->body()->get('id'));
                                
                                $this->objetRetour['success'] = true;
                                $this->objetRetour['message'] = $this->locales['activate_abonnement']['success'];
                                $this->objetRetour['results'] = $abonnement;
                            }else {
                                session()->set('errors', [
                                    'warning' => $this->locales['activate_abonnement']['warning']
                                ]);
                            }
                        }else {
                            session()->set('errors', [
                                'id_ecole' => $this->locales['activate_abonnement']['invalid_id_ecole_abonneent']
                            ]);
                        }
                    }else {
                        session()->set('errors', [
                            'id' => $this->locales['activate_abonnement']['expire_or_noactive']
                        ]);
                    }
                }else {
                    \session()->set('errors', [
                        'id' => $this->locales['find']['nothing']
                    ]);
                }
            }

            $this->trackErrors();
            $response->json($this->objetRetour);
        }
    }