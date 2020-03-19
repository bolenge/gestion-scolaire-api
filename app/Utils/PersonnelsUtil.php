<?php

    namespace App\Utils;

    use OpenApi\Annotations as OA;
    use App\Utils\Util;

    
    trait PersonnelsUtil
    {
        use Util;

        /**
         * @OA\RequestBody(
         * 		request="createPersonnelRequest",
         * 		description="Les données à renseigner",
         *		required=true,
         *      @OA\MediaType(
         *      	mediaType="application/x-www-form-urlencoded",
         *          @OA\Schema(
         *          	type="object",
         *				required={"fonction", "matricule", "id_acteur"},
         *              @OA\Property(type="string", property="fonction"),
         *              @OA\Property(type="string", property="matricule"),
         *              @OA\Property(type="integer", property="id_ecole"),
         *              @OA\Property(type="integer", property="id_acteur")
         *         )
         *     )
         * )
         * 
         * @var array
         */
        protected $rulesCreating = [
            'id' => 'int',
            'fonction' => 'required|min:3|max:200|alpha',
            'matricule' => 'required|min:3|max:200',
            'password' => 'required|min:6|alpha',
            'id_acteur' => 'required|int',
            'id_ecole' => 'required|int'
        ];

        /**
         * Réprésente le __construct de ce trait
         */
        public function traitPersonnelsUtilConstruct()
        {
            $this->locales = \locales('app')['personnels'];
        }
    }
    
