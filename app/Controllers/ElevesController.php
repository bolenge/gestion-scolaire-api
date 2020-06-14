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
                    'cond' => '(id_acteur='.$request->body()->id_acteur().
                        ' AND id_ecole='.$request->body()->id_ecole().
                        ') OR (id_ecole='.$request->body()->id_ecole().
                        ' AND matricule="'.$request->body()->id_ecole().'")'
                ], 'eleves');

                if (!empty($personnel)) {
                    $error = [
                        'warning' => $this->locales['creating']['already_exists']
                    ];

                    \session()->set('errors',
                    !session()->has('errors') 
                    ? $error 
                    : \array_merge(\session()->get('errors'), $error));
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
                            '" AND flag="1" 
                            AND id != '.$request->body('id').
                            ' AND id_ecole='.$request->body('id_ecole')
                    ], 'eleves');
    
                    if (!empty($eleve_for_matricule)) {
                        $error = [
                            'matricule' => $this->locales['creating']['matricule_used']
                        ];

                        \session()->set('errors',
                        !session()->has('errors') 
                        ? $error 
                        : array_merge($error, \session()->get('errors')));
                    }
    
                    if (!$this->model->exists('id', $request->body()->id_ecole(), 'ecoles')) {
                        $error = [
                            'id_ecole' => $this->locales['create']['id_ecole_invalid']
                        ];

                        \session()->set('errors',
                        !session()->has('errors') 
                        ? $error 
                        : array_merge($error, session()->get('errors')));
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
                }else {
                    $error = [
                        'id_acteur' => locales('app')['acteurs']['find']['nothing']
                    ];

                    \session()->set('errors', 
                    \session()->has('errors')
                    ? array_merge($error, \session()->get('errors'))
                    : $error);
                }
            }

            $this->trackErrors();
            $response->json($this->objetRetour);
        }

        /**
         * Permet de désactiver un eleve
         * 
         * @OA\Put(
         *      path="/eleves/desactiveEleve/{id}",
         *      tags={"Eleves"},
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
        public function desactiveEleve(Request $request, Response $response)
        {   
            $request->body()->set('id', $request->params()->get('id'));
            
            if ($request->validator($this->rulesCreating)) {
                $eleve = $this->model->findOne([
                    'cond' => 'id='.$request->body()->get('id').
                        ' AND flag="1"'
                ]);
                
                if (!empty($eleve)) {
                    
                    if ($eleve->state == "0") {
                        session()->set('errors', [
                            'warning' => $this->locales['desactive']['already_desactived']
                        ]);
                    }else {
                        $result = $this->model->update([
                            'id' => $request->body()->get('id'),
                            'state' => "0"
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
         * Permet de d'activer un eleve
         * 
         * @OA\Put(
         *      path="/eleves/activeEleve/{id}",
         *      tags={"Eleves"},
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
        public function activeEleve(Request $request, Response $response)
        {   
            $request->body()->set('id', $request->params()->get('id'));
            
            if ($request->validator($this->rulesCreating)) {
                $eleve = $this->model->findOne([
                    'cond' => 'id='.$request->body()->get('id').
                        ' AND flag="1"'
                ]);

                if (!empty($eleve)) {
                    if ($eleve->state == "1") {
                        session()->set('errors', [
                            'warning' => $this->locales['active']['already_actived']
                        ]);
                    }else {
                        $result = $this->model->update([
                            'id' => $request->body()->get('id'),
                            'state' => "1"
                        ]);

                        if ($result) {
                            $eleve->state = "1";
                            $this->objetRetour['success'] = true;
                            $this->objetRetour['message'] = $this->locales['active']['success'];
                            $this->objetRetour['results'] = $eleve;
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
    }