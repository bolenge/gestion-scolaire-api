<?php

    namespace App\Middleware;

    use Ekolo\Framework\Bootstrap\Middleware;
    use Ekolo\Framework\Http\Request;
    use Ekolo\Framework\Http\Response;
    // use Ekolo\Framework\Middleware\ErrorsMiddleware as Errors;

    class ErrorsMiddleware extends Middleware
    {
        /**
         * Contient l'erreur traquée
         * @var mixed
         */
        protected $error;

        /**
         * La localisation (langue)
         * @var array
         */
        protected $locales;

        /**
         * Renvoi l'erreur traquée
         * @return void
         */
        public function getError()
        {
            $this->locales = \locales('app')['errors'];

            if (!empty($error = $this->error)) {
                $error = 'error'.$error;
                $this->$error();
            }
        }

        /**
         * Permet de renvoyer à la page d'erreur 404
         * @return void
         */
        public function error404()
        {
            // $errors_path = \config('path.errors');
            // $errors_layout = $errors_path.'.error';

            // $this->response->setTemplate($errors_layout);
            // $this->response->render($errors_path.'.404', [], 404);

            $this->response->json(['message' => $this->locales['404']], [], 404);
        }

        /**
         * Modifie l'erreur traquée
         * @param mixed $error
         * @return void
         */
        public function setError($error)
        {
            if (!empty($error)) {
                $this->error = $error;
            }
        }
    }
    