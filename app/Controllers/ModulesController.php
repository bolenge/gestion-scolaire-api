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
            if ($request->validator($this->rules)) {
                if (!empty($module = $this->save($request, $response))) {
                    $this->objetRetour['success'] = true;
                    $this->objetRetour['message'] = \locales('app')['default']['creating']['success'];
                    $this->objetRetour['results'] = $module;
                }else {
                    $this->objetRetour['message'] = \locales('app')['default']['creating']['warning'];
                    session()->set('errors', [
                        'warning' => \locales('app')['default']['creating']['warning']
                    ]);
                }
            }

            $this->trackErrors();
            $response->json($this->objetRetour);
        }
    }