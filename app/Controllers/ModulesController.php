<?php

    namespace App\Controllers;

    use OpenApi\Annotations as OA;

    use Ekolo\Framework\Bootstrap\Controller;
    use Ekolo\Framework\Http\Request;
    use Ekolo\Framework\Http\Response;
    
    use App\Utils\ModulesUtil;
    use App\Repositories\ModulesRepository;

    /**
     * Controlleur pour les modules
     */
    class ModulesController extends Controller {

        use ModulesUtil;
        use ModulesRepository;

        /**
         * Les méthodes considerées comme des __contruct des traits
         */
        protected $traitsContructs = [
            'traitModulesUtilConstruct',
            'traitModulesRepositoryConstruct'
        ];

        /**
         * Permet de créer une nouveau module
         * 
         * @OA\Post(
         *      path="/modules/createModule",
         *      tags={"Modules"},
         *      security={"bearer"},
         *      @OA\RequestBody(ref="#/components/requestBodies/moduleRequestBody"),
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
        public function createModule(Request $request, Response $response)
        {
            debug($request->headers()->all());
            if ($request->validator($this->rules)) {
                if (!empty($module = $this->save($request, $response))) {
                    $this->objetRetour['success'] = true;
                    $this->objetRetour['message'] = \locales('app')['modules']['creating']['success'];
                    $this->objetRetour['results'] = $module;
                }else {
                    $this->objetRetour['message'] = \locales('app')['modules']['creating']['warning'];
                    session()->set('errors', [
                        'warning' => \locales('app')['modules']['creating']['warning']
                    ]);
                }
            }

            $this->trackErrors();
            $response->json($this->objetRetour);
        }

        /**
         * Permet de modifier les données d'un module
         * 
         * @OA\Put(
         *      path="/modules/updateModule/{id}",
         *      tags={"Modules"},
         *      @OA\Parameter(ref="#/components/parameters/id"),
         *      @OA\RequestBody(ref="#/components/requestBodies/moduleRequestBody"),
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
        public function updateModule(Request $request, Response $response)
        {   
            $request->body()->set('id', $request->params()->get('id'));
            
            if ($request->validator($this->rules)) {
                $module = $this->model->findOne([
                    'cond' => 'id='.$request->body()->id()
                ]);

                if (!empty($module)) {
                    if ($module->flag == "0") {
                        session()->set('errors', [
                            'warning' => $this->locales['updating']['desactive']
                        ]);
                    }else {
                        if (!empty($module = $this->save($request, $response))) {
                            $this->objetRetour['success'] = true;
                            $this->objetRetour['message'] = $this->locales['updating']['success'];
                            $this->objetRetour['results'] = $module;
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

            $this->trackErrors();
            $response->json($this->objetRetour);
        }

        /**
         * Permet de d'activer un module
         * 
         * @OA\Put(
         *      path="/modules/activeModule/{id}",
         *      tags={"Modules"},
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
        public function activeModule(Request $request, Response $response)
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
         * Permet de désactiver un module
         * 
         * @OA\Delete(
         *      path="/modules/desactiveModule/{id}",
         *      tags={"Modules"},
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
        public function desactiveModule(Request $request, Response $response)
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
         * Renvoi les informations d'un module
         * 
         * @OA\Get(
         *      path="/modules/getModuleById/{id}",
         *      tags={"Modules"},
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
        public function getModuleById(Request $request, Response $response)
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
         * Renvoi les modules par limite
         * 
         * @OA\Get(
         *      path="/modules/getListModules/{limit}/{offset}",
         *      tags={"Modules"},
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
        public function getListModules(Request $request, Response $response)
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