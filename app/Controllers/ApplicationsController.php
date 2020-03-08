<?php

    namespace App\Controllers;

    use OpenApi\Annotations as OA;

    use Ekolo\Framework\Bootstrap\Controller;
    use Ekolo\Framework\Http\Request;
    use Ekolo\Framework\Http\Response;

    /**
     * @OA\Info(title="API Gestion scolaire", version="0.1")
     * @OA\Server(
     *      url="http://localhost:3000",
     *      description="API de Gestion Scolaire, developpé par UHTec"
     * )
     */
    class ApplicationsController extends Controller {

        /**
         * Renvoi à la page d'acceuil
         * @param Request $request
         * @param Response $response
         */
        public function index(Request $request, Response $response)
        {
            $response->setTemplate('home');
            $response->render('docs.index', [
                'title' => 'Bienvenue sur API Gestion scolaire'
            ]);
        }


        public function docs(Request $request, Response $response)
        {
            $response->render('docs.docs', [
                'title' => 'API Gestion scolaire'
            ]);
        }
    }