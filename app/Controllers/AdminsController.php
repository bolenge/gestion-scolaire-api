<?php

    namespace App\Controllers;

    use OpenApi\Annotations as OA;

    use Ekolo\Framework\Bootstrap\Controller;
    use Ekolo\Framework\Http\Request;
    use Ekolo\Framework\Http\Response;

    use App\Utils\AdminsUtil;
    use App\Repositories\AdminsRepository;

    /**
     * Controlleur pour les admins
     */
    class AdminsController extends Controller {

        use AdminsUtil;
        use AdminsRepository;

        /**
         * Les méthodes considerées comme des __contruct des traits
         */
        protected $traitsContructs = [
            'traitAdminsUtilContruct',
            'traitAdminsRepositoryContruct'
        ];

        /**
         * Permet de faire connecté un admin
         * 
         * @OA\Post(
         *      path="/admins/login",
         *      tags={"Admins"},
         *      @OA\RequestBody(ref="#/components/requestBodies/adminLogin"),
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
        public function login(Request $request, Response $response)
        {
            if ($request->validator($this->rulesLogin)) {
                $admin = $this->model->findOne([
                    'cond' => 'username="'.$request->body()->username().'"'
                ]);

                if (!empty($admin)) {
                    if (bcrypt_verify_password($request->body()->password(), $admin->password)) {
                        if ($admin->flag == "1") {
                            $this->objetRetour['success'] = true;
                            $this->objetRetour['message'] = $this->locales['login']['success'];
                            $this->objetRetour['results'] = $admin;
                        }else {
                            session()->set('errors', [
                                'warning' => $this->locales['login']['account_blocked']
                            ]);
                        }
                    }else {
                        session()->set('errors', [
                            'password' => $this->locales['login']['password_invalid']
                        ]);
                    }
                }else {
                    $this->objetRetour['message'] = $this->locales['login']['username_or_password_invalid'];
                    session()->set('errors', [
                        'username' => $this->locales['login']['username_invalid']
                    ]);
                }
            }

            $this->trackErrors();
            $response->json($this->objetRetour);
        }

        /**
         * Renvoi les informations d'un admin
         * @OA\Get(
         *      path="/admins/getAdminById/{id}",
         *      tags={"Admins"},
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
        public function getAdminById(Request $request, Response $response)
        {
            if ($request->params()->has('id') && \is_int_valid($request->params()->get('id'))) {
                $admin = $this->model->findById($request->params()->get('id'));

                if (!empty($admin)) {
                    $this->objetRetour['success'] = true;
                    $this->objetRetour['message'] = $this->locales['find']['success'];
                    $this->objetRetour['results'] = $admin;
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
         * Permet de créer un nouvel admin
         * 
         * @OA\Post(
         *      path="/admins/createAdmin",
         *      tags={"Admins"},
         *      @OA\RequestBody(ref="#/components/requestBodies/createAdminRequest"),
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
        public function createAdmin(Request $request, Response $response)
        {
            if ($request->validator($this->rulesCreating)) {
                
                if (!in_array($request->body()->role(), $this->roles)) {
                    \session()->set('errors', [
                        'role' => $this->locales['create']['role_invalid']
                    ]);
                }

                if ($this->model->exists('username', $request->body()->username())) {
                    \session()->set('errors',
                    !session()->has('errors') ? [] : [
                        'username' => $this->locales['create']['username_used']
                    ]);
                }

                if (!$this->model->exists('id', $request->body()->id_acteur(), 'acteurs')) {
                    \session()->set('errors',
                    !session()->has('errors') ? [] : [
                        'id_acteur' => $this->locales['create']['id_acteur_invalid']
                    ]);
                }

                if (!session()->has('errors')) {
                    if (!empty($admin = $this->save($request, $response))) {
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
         *      path="/admins/updateAdmin/{id}",
         *      tags={"Admins"},
         *      @OA\Parameter(ref="#/components/parameters/id"),
         *      @OA\RequestBody(ref="#/components/requestBodies/createAdminRequest"),
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
        public function updateAdmin(Request $request, Response $response)
        {
            $request->body()->set('id', $request->params()->get('id'));

            if ($request->validator($this->rulesCreating)) {

                $admin = $this->model->findById($request->body('id'));

                if (!empty($admin)) {
                    if (!in_array($request->body()->role(), $this->roles)) {
                        \session()->set('errors', [
                            'role' => $this->locales['create']['role_invalid']
                        ]);
                    }
    
                    if ($this->model->exists('username', $request->body()->username()) && $request->body()->username() !== $admin->username ) {
                        \session()->set('errors',
                        !session()->has('errors') ? [] : [
                            'username' => $this->locales['create']['username_used']
                        ]);
                    }
    
                    if (!$this->model->exists('id', $request->body()->id_acteur(), 'acteurs')) {
                        \session()->set('errors',
                        !session()->has('errors') ? [] : [
                            'id_acteur' => $this->locales['create']['id_acteur_invalid']
                        ]);
                    }
    
                    if (!session()->has('errors')) {
                        if (!empty($admin = $this->save($request, $response))) {
                            $this->objetRetour['success'] = true;
                            $this->objetRetour['message'] = $this->locales['update']['success'];
                            $this->objetRetour['results'] = $admin;
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
         * Permet de désactiver un admin
         * 
         * @OA\Delete(
         *      path="/admins/desactiveAdmin/{id}",
         *      tags={"Admins"},
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
        public function desactiveAdmin(Request $request, Response $response)
        {   
            $request->body()->set('id', $request->params()->get('id'));
            
            if ($request->validator($this->rulesCreating)) {
                if (!empty($admin = $this->model->findOneById($request->body()->get('id')))) {
                    
                    if ($admin->flag == "0") {
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
         * Permet de d'activer un admin
         * 
         * @OA\Put(
         *      path="/admins/activeAdmin/{id}",
         *      tags={"Admins"},
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
        public function activeAdmin(Request $request, Response $response)
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

        /**
         * Renvoi la liste des admins
         * 
         * @OA\Get(
         *      path="/admins/getListAdmins/{limit}/{offset}",
         *      tags={"Admins"},
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
        public function getListAdmins(Request $request, Response $response)
        {
            $limit  = \is_int_valid($request->params()->get('limit')) ? $request->params()->get('limit') : 10;
            $offset = $request->params()->has('offset') ? (int) $request->params()->get('offset') : 0;

            $ecoles = $this->model->findAllAdmins($limit, $offset);

            if (!empty($ecoles)) {
                $this->objetRetour['success'] = true;
                $this->objetRetour['message'] = count($ecoles).' '.$this->locales['find']['success'];
                $this->objetRetour['results'] = $ecoles;
            }else {
                \session('errors', [
                    'warning' => $this->locales['find']['nothing']
                ]);
            }

            $this->trackErrors();
            $response->json($this->objetRetour);
        }
    }