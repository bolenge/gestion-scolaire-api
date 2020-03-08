<?php

    namespace App\Controllers;

    use OpenApi\Annotations as OA;

    use Ekolo\Framework\Bootstrap\Controller;
    use Ekolo\Framework\Http\Request;
    use Ekolo\Framework\Http\Response;
    
    use App\Utils\AdminsUtil;
    use App\Models\AdminsModel;

    /**
     * Controlleur pour les admins
     */
    class AdminsController extends Controller {

        use AdminsUtil;

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
            $this->model = new AdminsModel;
            $this->locales = \locales('app')['admins'];

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
         * Renvoi les informations d'un admin
         * @OA\Get(
         *      path="/admins/getAdminInfos/{id}",
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
        public function getAdminInfos(Request $request, Response $response)
        {
            debug($_GET);
        }

    }