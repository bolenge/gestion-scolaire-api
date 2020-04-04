<?php

    namespace App\Utils;

    use OpenApi\Annotations as OA;
    use App\Utils\Util;
    
    /**
     * Util des sous modules des écoles
     */
    trait SousModulesUtil
    {
        use Util;
        
        /**
         * @OA\Schema(
         *      schema="sousModule",
         *      description="Objet réprésentant un sous module",
         *      @OA\Property(type="integer", property="id_module"),
         *      @OA\Property(type="string", property="intitule"),
         *      @OA\Property(type="string", property="description")
         * )
         * 
         * @OA\RequestBody(
         * 		request="sousModuleRequestBody",
         * 		description="Les données à renseigner pour la création d'un sous module",
         *		required=true,
         *      @OA\MediaType(
         *      	mediaType="application/x-www-form-urlencoded",
         *          @OA\Schema(
         *          	type="object",
         *				required={"intitule", "description", "id_module"},
         *              ref="#/components/schemas/sousModule"
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
            'id_module' => 'required|int'
        ];

        /**
         * Réprésente le __construct de ce trait
         */
        public function traitSousModulesUtilConstruct()
        {
            $this->locales = \locales('app')['sous_modules'];
        }
    }