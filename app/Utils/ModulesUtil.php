<?php

    namespace App\Utils;

    use OpenApi\Annotations as OA;
    use App\Utils\Util;
    use App\Models\ModulesModel;
    
    trait ModulesUtil
    {
        use Util;
        
        /**
         * @OA\Schema(
         *      schema="module",
         *      description="Objet réprésentant un module",
         *      @OA\Property(type="string", property="intitule"),
         *      @OA\Property(type="string", property="description"),
         *      @OA\Property(type="number", property="tarif"),
         *      @OA\Property(type="integer", property="nbre_jours")
         * )
         * 
         * @OA\RequestBody(
         * 		request="moduleRequestBody",
         * 		description="Les données à renseigner pour la création d'un module",
         *		required=true,
         *      @OA\MediaType(
         *      	mediaType="application/x-www-form-urlencoded",
         *          @OA\Schema(
         *          	type="object",
         *				required={"intitule", "description", "tarif", "nbre_jours"},
         *              ref="#/components/schemas/module"
         *         )
         *     )
         * )
         * 
         * @var array
         */
        protected $rules = [
            'id' => 'int',
            'intitule' => 'required|min:2|max:300|alpha',
            'descitption' => 'required|min:5|alpha',
            'tarif' => 'required|numeric',
            'nbre_jours' => 'required|int'
        ];

        /**
         * Réprésente le __construct de ce trait
         */
        public function traitModulesUtilConstruct()
        {
            $this->locales = \locales('app')['default'];
        }
    }