<?php

    namespace App\Utils;

    use OpenApi\Annotations as OA;
    use App\Utils\Util;
    
    trait AbonnementsUtil
    {
        use Util;
        
        /**
         * @OA\Schema(
         *      schema="abonnement",
         *      description="Objet réprésentant un abonnement",
         *      @OA\Property(type="integer", property="id_module"),
         *      @OA\Property(type="integer", property="id_ecole"),
         *      @OA\Property(type="double", property="montant_paye"),
         *      @OA\Property(type="int", property="delai", description="Le nombre de jour de l'abonnement")
         * )
         * 
         * @OA\RequestBody(
         * 		request="abonnementRequestBody",
         * 		description="Les données à renseigner pour la création d'un abonnement",
         *		required=true,
         *      @OA\MediaType(
         *      	mediaType="application/x-www-form-urlencoded",
         *          @OA\Schema(
         *          	type="object",
         *				required={"id_module", "id_ecole", "montant_paye", "delai"},
         *              ref="#/components/schemas/abonnement"
         *         )
         *     )
         * )
         * 
         * @var array
         */
        protected $rules = [
            'id' => 'int',
            'id_module' => 'required|int',
            'id_ecole' => 'required|int',
            'delai' => 'required|int',
            'montant_paye' => 'required|numeric'
        ];

        /**
         * Réprésente le __construct de ce trait
         */
        public function traitAbonnementsUtilConstruct()
        {
            $this->locales = \locales('app')['abonnements'];
        }

        /**
         * Permet traquer les erreurs sur l'école et le module
         * @return void
         */
        public function trackErrorsModuleAndEcole($request, $response)
        {
            if (!empty($module = $this->model->findOneById($request->body('id_module'), 'modules'))) {
                if ($module->flag == '0') {
                    \session()->set('errors', [
                        'id_module' => $this->locales['creating']['module_desactived']
                    ]);
                }
            }else {
                \session()->set('errors', [
                    'id_module' => locales('app')['modules']['find']['invalid_id']
                ]);
            }

            if (!empty($ecole = $this->model->findOneById($request->body('id_ecole'), 'ecoles'))) {
                if ($ecole->flag === '0') {
                    $errors = session()->has('errors') 
                            ? session()->get('errors') + ['id_ecole' => $this->locales['creating']['ecole_desactived']] 
                            : ['id_ecole' => $this->locales['creating']['ecole_desactived']];
                    
                    \session()->set('errors', $errors);
                }
            }else {
                \session()->set('errors', [
                    'id_ecole' => locales('app')['ecoles']['verify']['empty']
                ]);
            }
        }
    }