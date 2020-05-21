<?php

    namespace App\Controllers;

    use Ekolo\Framework\Bootstrap\Controller;
    use Ekolo\Framework\Http\Request;
    use Ekolo\Framework\Http\Response;

    use App\Utils\PersonnelsGerantsUtil;
    use App\Repositories\PersonnelsGerantsRepository;

    class PersonnelsGerantsController extends Controller {

        use PersonnelsGerantsUtil;
        use PersonnelsGerantsRepository;

        /**
         * Les méthodes considerées comme des __contruct des traits
         */
        protected $traitsContructs = [
            'traitPersonnelsGerantsUtilConstruct',
            'traitPersonnelsGerantsRepositoryConstruct'
        ];


        /**
         * Permet de créer un nouveau personnel gérant d'une école
         * 
         * @OA\Post(
         *      path="/personnels/gerants/createPersonnelGerant",
         *      tags={"Personnels"},
         *      @OA\RequestBody(ref="#/components/requestBodies/createPersonnelGerantRequest"),
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
        public function createPersonnelGerant(Request $request, Response $response)
        {
            if ($request->validator($this->rulesCreating)) {
                $personnel = $this->model->findOne([
                    'cond' => 'id='.$request->body()->id_personnel().
                    ' AND state="1" AND id_ecole='.$request->body()->id_ecole()
                ], 'personnels');

                if ($personnel) {
                    $personnel_gerant_exists = $this->model->findOne([
                        'cond' => 'id_personnel='.$request->body()->id_personnel().
                            ' AND id_ecole='.$request->body()->id_ecole().
                            ' AND id_sous_module='.$request->body()->id_sous_module().
                            ' AND state="1"'
                    ], 'personnels_gerants');
    
                    if (empty($personnel_gerant_exists)) {
                        $personnel_gerant = $this->model->findOne([
                            'cond' => 'username="'.$request->body()->username().
                                '" AND id_ecole='.$request->body()->id_ecole().
                                ' AND state="1"'
                        ], 'personnels_gerants');
        
                        if (empty($personnel_gerant)) {
                            $abonnement = $this->model->findOne([
                                'cond' => 'id='.$request->body()->id_abonnement().
                                ' AND state="1" AND id_ecole='.$request->body()->id_ecole()
                            ], 'abonnements');
            
                            if ($abonnement) {
                                $sous_module = $this->model->findOne([
                                    'cond' => 'id='.$request->body()->id_sous_module().
                                    ' AND state="1"'
                                ], 'sous_modules');

                                if ($sous_module->id_module == $abonnement->id_module) {
                                    // Sauvegarde
                                    if (!session()->has('errors')) {
                                        if (!empty($personnel_gerant_creating = $this->save($request, $response))) {
                                            $this->objetRetour['success'] = true;
                                            $this->objetRetour['message'] =  \locales('app')['default']['creating']['success'];
                                            $this->objetRetour['results'] = $personnel_gerant_creating;
                                        }else {
                                            $this->objetRetour['message'] = \locales('app')['default']['creating']['warning'];
                                            session()->set('errors', [
                                                'warning' => \locales('app')['default']['creating']['warning']
                                            ]);
                                        }
                                    }
                                }else {
                                    $error_sous_module = [ 'id_sous_module' => \locales('app')['sous_modules']['find']['unsubscribe']];
                
                                    \session()->set('errors',
                                    !session()->has('errors') 
                                    ? $error_sous_module
                                    : array_merge(session()->get('errors'), $error_sous_module));
                                }
                            }else {
                                $error_abonnement = [ 'id_abonnement' => \locales('app')['abonnements']['find']['unsubsribe']];
            
                                \session()->set('errors',
                                !session()->has('errors') 
                                ? $error_abonnement
                                : array_merge(session()->get('errors'), $error_abonnement));
                            }
                        }else {
                            $error_personnel_username = [
                                'username' => $this->locales['create']['username_used']
                            ];
        
                            \session()->set('errors',
                            !session()->has('errors') 
                            ? $error_personnel_username 
                            : \array_merge($error_personnel_username, session()->get('errors')));
                        }
                        
                    }else {
                        $error_personnel_gerant_exists = [
                            'id_personnel' => $this->locales['create']['already_gerant_sous_module']
                        ];
    
                        \session()->set('errors',
                        !session()->has('errors') 
                        ? $error_personnel_gerant_exists 
                        : \array_merge($error_personnel_gerant_exists, session()->get('errors')));
                    }
                    
                }else {
                    $error_personnel = [ 'id_personnel' => $this->locales['find']['invalid_unexists']];

                    \session()->set('errors',
                    !session()->has('errors') 
                    ? $error_personnel
                    : array_merge(session()->get('errors'), $error_personnel));
                }
            }

            $this->trackErrors();
            $response->json($this->objetRetour);
        }

        /**
         * Permet de faire connecter un personnel gérant
         * 
         * @OA\Post(
         *      path="/personnels/gerants/loginPersonnelGerant",
         *      tags={"Personnels"},
         *      @OA\RequestBody(ref="#/components/requestBodies/loginPersonnelGerantRequest"),
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
        public function loginPersonnelGerant(Request $request, Response $response)
        {
            if ($request->validator($this->rulesLogin)) {

                $gerant = $this->model->findOne([
                    'cond' => 'username="'.$request->body()->username().
                        '" AND state="1"'
                ], 'personnels_gerants');

                if (!empty($gerant)) {
                    if (\bcrypt_verify_password($request->body()->password(), $gerant->password)) {
                        if (!session()->has('errors')) {
                            $this->objetRetour['success'] = true;
                            $this->objetRetour['message'] = $this->locales['login']['success'];
                            $this->objetRetour['results'] = $gerant;
                        }
                    }else {
                        $error_password_gerant = [
                            'warning' => $this->locales['login']['invalid_password']
                        ];

                        \session()->set('errors',
                        !session()->has('errors') ? $error_password_gerant : \array_merge($error_password_gerant, \session()->get('errors')));
                    }
                }else {
                    $error_gerant = [
                        'warning' => $this->locales['create']['invalid_password_or_username']
                    ];
                    \session()->set('errors',
                    !session()->has('errors') ? $error_gerant : \array_merge($error_gerant, \session()->get('errors')));
                }
            }

            $this->trackErrors();
            $response->json($this->objetRetour);
        }
    }