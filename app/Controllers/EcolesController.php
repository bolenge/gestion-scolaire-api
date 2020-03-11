<?php

    namespace App\Controllers;

    use OpenApi\Annotations as OA;

    use Ekolo\Framework\Bootstrap\Controller;
    use Ekolo\Framework\Http\Request;
    use Ekolo\Framework\Http\Response;
    
    use App\Utils\EcolesUtil;
    use App\Repositories\EcolesRepository;

    /**
     * Controlleur pour les écoles
     */
    class EcolesController extends Controller {

        use EcolesUtil;
        use EcolesRepository;

        /**
         * Les méthodes considerées comme des __contruct des traits
         */
        protected $traitsContructs = [
            'traitEcolesUtilContruct',
            'traitEcolesRepositoryContruct'
        ];

        /**
         * Permet de créer une nouvelle école
         * 
         * @OA\Post(
         *      path="/ecoles/createEcole",
         *      tags={"Ecoles"},
         *      @OA\RequestBody(ref="#/components/requestBodies/ecoleRequestBody"),
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
        public function createEcole(Request $request, Response $response)
        {
            if ($request->validator($this->rules)) {
                if ($this->model->exists('num_agrement', $request->body()->num_agrement())) {
                    session()->set('errors', [
                        'num_agrement' => $this->locales['create']['num_agrement_in_used']
                    ]);
                }

                if ($request->body()->id_media_logo() && !$this->model->exists('id', $request->body()->id_media_logo(), 'medias')) {
                    $errors = session()->has('errors') ? session()->get('errors') : [];
                    session()->set('errors', \array_merge($errors, [
                        'id_media_logo' => $this->locales['create']['id_media_logo_invalid']
                    ]));
                }

                if (!session()->has('errors')) {
                    if (!empty($ecole = $this->save($request, $response))) {
                        $this->objetRetour['success'] = true;
                        $this->objetRetour['message'] = $this->locales['create']['success'];
                        $this->objetRetour['results'] = $ecole;
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
         * Permet de modifier les données d'une école
         * 
         * @OA\Put(
         *      path="/ecoles/updateEcole/{id}",
         *      tags={"Ecoles"},
         *      @OA\Parameter(ref="#/components/parameters/id"),
         *      @OA\RequestBody(ref="#/components/requestBodies/ecoleRequestBody"),
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
        public function updateEcole(Request $request, Response $response)
        {   
            $request->body()->set('id', $request->params()->get('id'));
            
            if ($request->validator($this->rules)) {
                $ecole = $this->model->findOne([
                    'cond' => 'id='.$request->body()->id()
                ]);

                if (!empty($ecole)) {
                    if ($ecole->flag == "0") {
                        session()->set('errors', [
                            'warning' => $this->locales['update']['desactive']
                        ]);
                    }else {
                        if ($ecole->num_agrement !== $request->body()->num_agrement() && $this->model->exists('num_agrement', $request->body()->num_agrement())) {
                            session()->set('errors', [
                                'num_agrement' => $this->locales['create']['num_agrement_in_used']
                            ]);
                        }

                        if ($request->body()->id_media_logo() && !$this->model->exists('id', $request->body()->id_media_logo(), 'medias')) {
                            session()->set('errors', [
                                'id_media_logo' => $this->locales['create']['id_media_logo_invalid']
                            ]);
                        }

                        if (!session()->has('errors')) {
                            if (!empty($ecole = $this->save($request, $response))) {
                                $this->objetRetour['success'] = true;
                                $this->objetRetour['message'] = $this->locales['update']['success'];
                                $this->objetRetour['results'] = $ecole;
                            }else {
                                $this->objetRetour['message'] = $this->locales['update']['warning'];
                                session()->set('errors', [
                                    'warning' => $this->locales['update']['warning']
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
         * Permet de désactiver une école
         * 
         * @OA\Delete(
         *      path="/ecoles/desactiveEcole/{id}",
         *      tags={"Ecoles"},
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
        public function desactiveEcole(Request $request, Response $response)
        {   
            $request->body()->set('id', $request->params()->get('id'));
            
            if ($request->validator($this->rules)) {
                if (!empty($ecole = $this->model->findOneById($request->body()->get('id')))) {
                    
                    if ($ecole->flag == "0") {
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
         * Permet de d'activer une école
         * 
         * @OA\Put(
         *      path="/ecoles/activeEcole/{id}",
         *      tags={"Ecoles"},
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
        public function activeEcole(Request $request, Response $response)
        {   
            $request->body()->set('id', $request->params()->get('id'));
            
            if ($request->validator($this->rules)) {
                if (!empty($ecole = $this->model->findOneById($request->body()->get('id')))) {
                    
                    if ($ecole->flag == "1") {
                        session()->set('errors', [
                            'warning' => $this->locales['active']['already_actived']
                        ]);
                    }else {
                        $result = $this->model->update([
                            'id' => $request->body()->get('id'),
                            'flag' => "1"
                        ]);

                        if ($result) {
                            $this->objetRetour['success'] = true;
                            $this->objetRetour['message'] = $this->locales['active']['success'];
                            $this->objetRetour['results'] = $result;
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
    }