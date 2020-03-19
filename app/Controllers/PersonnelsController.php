<?php

    namespace App\Controllers;

    use Ekolo\Framework\Bootstrap\Controller;
    use Ekolo\Framework\Http\Request;
    use Ekolo\Framework\Http\Response;

    use App\Utils\PersonnelsUtil;
    use App\Repositories\PersonnelsRepository;

    class PersonnelsController extends Controller {

        use PersonnelsUtil;
        use PersonnelsRepository;

        /**
         * Les méthodes considerées comme des __contruct des traits
         */
        protected $traitsContructs = [
            'traitPersonnelsUtilConstruct',
            'traitPersonnelsRepositoryConstruct'
        ];


        /**
         * Permet de créer un nouveau personnel d'une école
         * 
         * @OA\Post(
         *      path="/personnels/createPersonnel",
         *      tags={"Personnels"},
         *      @OA\RequestBody(ref="#/components/requestBodies/createPersonnelRequest"),
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
        public function createPersonnel(Request $request, Response $response)
        {
            // debug($request->body()->all());
            if ($request->validator($this->rulesCreating)) {

                if (!$this->model->exists('id', $request->body()->id_acteur(), 'acteurs')) {
                    \session()->set('errors',
                    !session()->has('errors') ? [] : [
                        'id_acteur' => $this->locales['create']['id_acteur_invalid']
                    ]);
                }

                $personnel = $this->model->findOne([
                    'cond' => 'matricule="'.$request->body()->matricule().
                        '" AND id_ecole='.$request->body()->id_ecole()
                ], 'personnels');

                if (!empty($personnel)) {
                    \session()->set('errors',
                    !session()->has('errors') ? [] : [
                        'matricule' => $this->locales['create']['matricule_used']
                    ]);
                }

                if (!$this->model->exists('id', $request->body()->id_ecole(), 'acteurs')) {
                    \session()->set('errors',
                    !session()->has('errors') ? [] : [
                        'id_ecole' => $this->locales['create']['id_ecole_invalid']
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

    }