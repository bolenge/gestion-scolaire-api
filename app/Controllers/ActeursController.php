<?php

    namespace App\Controllers;

    use OpenApi\Annotations as OA;

    use Ekolo\Framework\Bootstrap\Controller;
    use Ekolo\Framework\Http\Request;
    use Ekolo\Framework\Http\Response;
    
    use App\Utils\ActeursUtil;
    use App\Repositories\ActeursRepository;

    /**
     * Controlleur pour les acteurs
     */
    class ActeursController extends Controller {

        use ActeursUtil;
        use ActeursRepository;

        /**
         * Les méthodes considerées comme des __contruct des traits
         */
        protected $traitsContructs = [
            'traitActeursUtilContruct',
            'traitActeursRepositoryContruct'
        ];

        /**
         * Permet de créer un nouvel acteur
         * 
         * @OA\Post(
         *      path="/acteurs/createActeur",
         *      tags={"Acteurs"},
         *      @OA\RequestBody(ref="#/components/requestBodies/createActeurRequest"),
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
        public function createActeur(Request $request, Response $response)
        {
            if ($request->validator($this->rulesCreating)) {
                if (!in_array($request->body()->sexe(), $this->sexes)) {
                    \session()->set('errors',
                    !session()->has('errors') ? [] : [
                        'sexe' => $this->locales['create']['sexe_invalid']
                    ]);
                }

                if (!session()->has('errors')) {
                    if (!empty($acteur = $this->save($request, $response))) {
                        $this->objetRetour['success'] = true;
                        $this->objetRetour['message'] = $this->locales['create']['success'];
                        $this->objetRetour['results'] = $acteur;
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

    }