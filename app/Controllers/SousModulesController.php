<?php

    namespace App\Controllers;

    use OpenApi\Annotations as OA;

    use Ekolo\Framework\Bootstrap\Controller;
    use Ekolo\Framework\Http\Request;
    use Ekolo\Framework\Http\Response;
    
    use App\Utils\SousModulesUtil;
    use App\Repositories\SousModulesRepository;

    /**
     * Controlleur pour les sous modules
     */
    class SousModulesController extends Controller {

        use SousModulesUtil;
        use SousModulesRepository;

        /**
         * Les méthodes considerées comme des __contruct des traits
         */
        protected $traitsContructs = [
            'traitSousModulesUtilConstruct',
            'traitSousModulesRepositoryConstruct'
        ];

        /**
         * Permet de créer un nouveau sous module
         * 
         * @OA\Post(
         *      path="/sousModules/createSousModule",
         *      tags={"Sous modules"},
         *      security={"bearer"},
         *      @OA\RequestBody(ref="#/components/requestBodies/sousModuleRequestBody"),
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
        public function createSousModule(Request $request, Response $response)
        {
            if ($request->validator($this->rules)) {
                
                if (!empty($module = $this->model->findOneById($request->body('id_module'), 'modules'))) {
                    if ($module->flag === '0') {
                        \session()->set('errors', [
                            'warning' => $this->locales['creating']['module_desactived']
                        ]);
                    }else {
                        
                        if (!empty($sous_module = $this->save($request, $response))) {
                            $this->objetRetour['success'] = true;
                            $this->objetRetour['message'] = $this->locales['creating']['success'];
                            $this->objetRetour['results'] = $sous_module;
                        }else {
                            $this->objetRetour['message'] = $this->locales['creating']['warning'];
                            session()->set('errors', [
                                'warning' => $this->locales['creating']['warning']
                            ]);
                        }
                    }
                }else {
                    session()->set('errors', [
                        'id_module' => \locales('app')['modules']['find']['invalid_id']
                    ]);
                }
            }

            $this->trackErrors();
            $response->json($this->objetRetour);
        }

        /**
         * Permet de modifier les données d'un sous module
         * 
         * @OA\Put(
         *      path="/sousModules/updateSousModule/{id}",
         *      tags={"Sous modules"},
         *      security={"bearer"},
         *      @OA\Parameter(ref="#/components/parameters/id"),
         *      @OA\RequestBody(ref="#/components/requestBodies/sousModuleRequestBody"),
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
        public function updateSousModule(Request $request, Response $response)
        {   
            $request->body()->set('id', $request->params()->get('id'));
            
            if ($request->validator($this->rules)) {
                if (!empty($module = $this->model->findOneById($request->body('id_module'), 'modules'))) {
                    if ($module->flag === '0') {
                        \session()->set('errors', [
                            'warning' => $this->locales['updating']['module_desactived']
                        ]);
                    }else {
                        $sous_module = $this->model->findOne([
                            'cond' => 'id='.$request->body()->id()
                        ], 'sous_modules');

                        if (!empty($sous_module)) {
                            if ($sous_module->flag == "0") {
                                session()->set('errors', [
                                    'warning' => $this->locales['updating']['desactive']
                                ]);
                            }else {
                                if (!empty($sous_module = $this->save($request, $response))) {
                                    $this->objetRetour['success'] = true;
                                    $this->objetRetour['message'] = $this->locales['updating']['success'];
                                    $this->objetRetour['results'] = $sous_module;
                                }else {
                                    $this->objetRetour['message'] = $this->locales['updating']['warning'];
                                    session()->set('errors', [
                                        'warning' => $this->locales['updating']['warning']
                                    ]);
                                }
                            }
                        }else {
                            \session()->set('errors', [
                                'warning' => $this->locales['verify']['empty']
                            ]);
                        }
                    }
                }else {
                    session()->set('errors', [
                        'id_module' => \locales('app')['modules']['find']['invalid_id']
                    ]);
                }
            }

            $this->trackErrors();
            $response->json($this->objetRetour);
        }

        /**
         * Permet de d'activer un sous module
         * 
         * @OA\Put(
         *      path="/sousModules/activeSousModule/{id}",
         *      tags={"Sous modules"},
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
        public function activeSousModule(Request $request, Response $response)
        {   
            $request->body()->set('id', $request->params()->get('id'));
            
            if ($request->validator($this->rules)) {
                if (!empty($module = $this->model->findOneById($request->body()->get('id')))) {
                    
                    if ($module->flag == "1") {
                        session()->set('errors', [
                            'warning' => $this->locales['active']['already_actived']
                        ]);
                    }else {
                        $result = $this->model->update([
                            'id' => $request->body()->get('id'),
                            'flag' => "1"
                        ]);

                        if ($result) {
                            $module->flag = "1";
                            $this->objetRetour['success'] = true;
                            $this->objetRetour['message'] = $this->locales['active']['success'];
                            $this->objetRetour['results'] = $module;
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
         * Permet de désactiver un sous module
         * 
         * @OA\Delete(
         *      path="/sousModules/desactiveSousModule/{id}",
         *      tags={"Sous modules"},
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
        public function desactiveSousModule(Request $request, Response $response)
        {   
            $request->body()->set('id', $request->params()->get('id'));
            
            if ($request->validator($this->rules)) {
                if (!empty($module = $this->model->findOneById($request->body()->get('id')))) {
                    
                    if ($module->flag == "0") {
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
         * Renvoi les informations d'un sous module
         * 
         * @OA\Get(
         *      path="/sousModules/getSousModuleById/{id}",
         *      tags={"Sous modules"},
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
        public function getSousModuleById(Request $request, Response $response)
        {
            if ($request->params()->has('id') && \is_int_valid($request->params()->get('id'))) {
                $module = current($this->model->findById($request->params()->get('id')));

                if (!empty($module)) {
                    $this->objetRetour['success'] = true;
                    $this->objetRetour['message'] = $this->locales['find']['success'];
                    $this->objetRetour['results'] = $module;
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
         * Renvoi la liste des sous modules par limite
         * 
         * @OA\Get(
         *      path="/sousModules/getListSousModules/{limit}/{offset}",
         *      tags={"Sous modules"},
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
        public function getListSousModules(Request $request, Response $response)
        {
            $limit  = \is_int_valid($request->params()->get('limit')) ? $request->params()->get('limit') : 10;
            $offset = $request->params()->has('offset') ? (int) $request->params()->get('offset') : 0;

            $modules = $this->model->findAllModules($limit, $offset);

            if (!empty($modules)) {
                $this->objetRetour['success'] = true;
                $this->objetRetour['message'] = count($modules).' '.$this->locales['find']['success'];
                $this->objetRetour['results'] = $modules;
            }else {
                \session('errors', [
                    'warning' => $this->locales['find']['nothing']
                ]);
            }

            $this->trackErrors();
            $response->json($this->objetRetour);
        }
    }