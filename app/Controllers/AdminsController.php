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
            if ($request->validator($this->rules)) {
                $admin = $this->model->findOne([
                    'cond' => 'username="'.$request->body()->username().'"'
                ]);

                if (!empty($admin)) {
                    if ($admin->password === $request->body()->password()) {
                        $this->objetRetour['success'] = true;
                        $this->objetRetour['message'] = $this->locales['login']['success'];
                        $this->objetRetour['results'] = $admin;
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
            
        }

    }