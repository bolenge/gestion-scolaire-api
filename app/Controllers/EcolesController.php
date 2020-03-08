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
                    session()->set('errors', [
                        'id_media_logo' => $this->locales['create']['id_media_logo_invalid']
                    ]);
                }

                if (!session()->has('errors')) {
                    if (!empty($ecoles = $this->save($request, $response))) {
                        $this->objetRetour['success'] = true;
                        $this->objetRetour['message'] = $this->locales['create']['success'];
                        $this->objetRetour['results'] = $ecoles;
                    }else {
                        $this->objetRetour['message'] = $this->locales['create']['warning'];
                        session()->set('errors', [
                            'warning' => $this->locales['create']['warning']
                        ]);
                    }
                }
            }

            if (session()->has('errors')) {
                $errors = session('errors');
                $this->objetRetour['errors'] = $errors;

                if (empty($this->objetRetour['message'])) {
                    $errorsValues = array_values($errors);
                    $this->objetRetour['message'] = \implode('<br/>', $errorsValues);
                }
                
                session()->remove('errors');
            }

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
                if (!empty($ecole = $this->model->findOneById($request->body()->id()))) {

                    if ($ecole->num_agrement !== $request->body()->num_agrement() && $this->model->exists('num_agrement')) {
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
                        if (!empty($ecoles = $this->save($request, $response))) {
                            $this->objetRetour['success'] = true;
                            $this->objetRetour['message'] = $this->locales['create']['success'];
                            $this->objetRetour['results'] = $ecoles;
                        }else {
                            $this->objetRetour['message'] = $this->locales['create']['warning'];
                            session()->set('errors', [
                                'warning' => $this->locales['create']['warning']
                            ]);
                        }
                    }
                }
            }

            if (session()->has('errors')) {
                $errors = session('errors');
                $this->objetRetour['errors'] = $errors;

                if (empty($this->objetRetour['message'])) {
                    $errorsValues = array_values($errors);
                    $this->objetRetour['message'] = \implode('<br/>', $errorsValues);
                }
                
                session()->remove('errors');
            }

            $response->json($this->objetRetour);
        }
    }