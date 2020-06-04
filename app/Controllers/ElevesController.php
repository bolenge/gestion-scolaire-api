<?php

    namespace App\Controllers;

    use Ekolo\Framework\Bootstrap\Controller;
    use Ekolo\Framework\Http\Request;
    use Ekolo\Framework\Http\Response;

    use App\Utils\ElevesUtil;
    use App\Repositories\ElevesRepository;

    class ElevesController extends Controller {

        use ElevesUtil;
        use ElevesRepository;

        /**
         * Les méthodes considerées comme des __contruct des traits
         */
        protected $traitsContructs = [
            'traitElevesUtilConstruct',
            'traitElevesRepositoryConstruct'
        ];


        /**
         * Permet de créer un nouveau eleve d'une école
         * 
         * @OA\Post(
         *      path="/eleves/createEleve",
         *      tags={"Eleves"},
         *      @OA\RequestBody(ref="#/components/requestBodies/createEleveRequest"),
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
        public function createEleve(Request $request, Response $response)
        {
            if ($request->validator($this->rulesCreating)) {

                if (!$this->model->exists('id', $request->body()->id_acteur(), 'acteurs')) {
                    $error_acteur = [ 'id_acteur' => $this->locales['create']['id_acteur_invalid']];
                    
                    \session()->set('errors',
                    !session()->has('errors') 
                    ? $error_acteur
                    : array_merge(session()->get('errors'), $error_acteur));
                }

                $personnel = $this->model->findOne([
                    'cond' => 'matricule="'.$request->body()->matricule().
                        '" AND id_ecole='.$request->body()->id_ecole()
                ], 'eleves');

                if (!empty($personnel)) {
                    \session()->set('errors',
                    !session()->has('errors') ? [] : [
                        'matricule' => $this->locales['create']['already_exists']
                    ]);
                }

                if (!$this->model->exists('id', $request->body()->id_ecole(), 'ecoles')) {
                    \session()->set('errors',
                    !session()->has('errors') 
                    ? locales('app')['ecoles']['find']['unexists'] 
                    : array_merge(\session()->get('errors'), [
                        'id_ecole' => locales('app')['ecoles']['find']['unexists']
                    ]));
                }

                if (!session()->has('errors')) {
                    if (!empty($personnel = $this->save($request, $response))) {
                        $this->objetRetour['success'] = true;
                        $this->objetRetour['message'] = $this->locales['creating']['success'];
                        $this->objetRetour['results'] = $personnel;
                    }else {
                        $this->objetRetour['message'] = $this->locales['creating']['warning'];
                        session()->set('errors', [
                            'warning' => $this->locales['creating']['warning']
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
         *      path="/eleves/updateEleve/{id}",
         *      tags={"Eleves"},
         *      @OA\Parameter(ref="#/components/parameters/id"),
         *      @OA\RequestBody(ref="#/components/requestBodies/updateEleveRequest"),
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
        public function updateEleve(Request $request, Response $response)
        {
            $request->body()->set('id', $request->params()->get('id'));

            if ($request->validator($this->rulesCreating)) {

                $eleve = $this->model->findOne([
                    'cond' => 'id='.$request->body('id').
                        ' AND id_acteur='.$request->body()->id_acteur()
                ], 'eleves');

                if (!empty($eleve)) {
                    $eleve_for_matricule = $this->model->findOne([
                        'cond' => 'matricule="'.$request->body()->matricule().
                            '" AND flag="1"'
                    ], 'eleves');

                    if (empty($eleve_for_matricule)) {
                        $eleve_for_matricule = new \stdClass;
                        $eleve_for_matricule->id = null;
                    }
    
                    if ($eleve_for_matricule->id == $eleve->id) {
                        \session()->set('errors',
                        !session()->has('errors') ? [] : [
                            'matricule' => $this->locales['create']['matricule_used']
                        ]);
                    }
    
                    if (!$this->model->exists('id', $request->body()->id_ecole(), 'ecoles')) {
                        \session()->set('errors',
                        !session()->has('errors') ? [] : [
                            'id_ecole' => $this->locales['create']['id_ecole_invalid']
                        ]);
                    }
    
                    if (!session()->has('errors')) {
                        if (!empty($eleve_updating = $this->save($request, $response))) {
                            $this->objetRetour['success'] = true;
                            $this->objetRetour['message'] = $this->locales['updating']['success'];
                            $this->objetRetour['results'] = $eleve_updating;
                        }else {
                            $this->objetRetour['message'] = $this->locales['updating']['warning'];
                            session()->set('errors', [
                                'warning' => $this->locales['updating']['warning']
                            ]);
                        }
                    }
                }
            }

            $this->trackErrors();
            $response->json($this->objetRetour);
        }

    }