<?php

    namespace App\Controllers;

    use OpenApi\Annotations as OA;

    use Ekolo\Framework\Bootstrap\Controller;
    use Ekolo\Framework\Http\Request;
    use Ekolo\Framework\Http\Response;
    
    use App\Utils\AdminsUtil;
    use App\Models\AdminsModel;

    /**
     * Controlleur pour les acteurs
     */
    class UsersController extends Controller {

        use AdminsUtil;

        /**
         * Permet de créer un nouvel utilisateur
         */
        public function create(Request $request, Response $response)
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
                $errorsValues = array_values($errors);

                $this->objetRetour['errors'] = $errors;

                if (empty($this->objetRetour['message'])) {
                    $this->objetRetour['message'] = \implode('<br/>', $errorsValues);
                }
                
                session()->remove('errors');
            }

            $response->json($this->objetRetour);
        }

    }