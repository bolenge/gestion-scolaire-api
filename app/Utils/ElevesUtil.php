<?php

    namespace App\Utils;

    use OpenApi\Annotations as OA;
    use App\Utils\Util;

    
    trait ElevesUtil
    {
        use Util;

        /**
         * @OA\RequestBody(
         * 		request="createEleveRequest",
         * 		description="Les données à renseigner",
         *		required=true,
         *      @OA\MediaType(
         *      	mediaType="application/x-www-form-urlencoded",
         *          @OA\Schema(
         *          	type="object",
         *				required={"id_ecole", "matricule", "id_acteur"},
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
            'matricule' => 'required|min:3|max:200',
            'password' => 'required|min:6|alpha',
            'id_acteur' => 'required|int',
            'id_ecole' => 'required|int'
        ];

        /**
         * @OA\RequestBody(
         * 		request="updateEleveRequest",
         * 		description="Les données à renseigner",
         *		required=true,
         *      @OA\MediaType(
         *      	mediaType="application/x-www-form-urlencoded",
         *          @OA\Schema(
         *          	type="object",
         *				required={"id_ecole", "matricule", "id_acteur"},
         *              @OA\Property(type="integer", property="id_ecole"),
         *              @OA\Property(type="integer", property="id_acteur"),
         *              @OA\Property(type="string", property="matricule")
         *         )
         *     )
         * )
         * 
         * @var array
         */
        protected $rulesUpdating = [
            'id' => 'int',
            'matricule' => 'required|min:3|max:200',
            'password' => 'required|min:6|alpha',
            'id_acteur' => 'required|int',
            'id_ecole' => 'required|int'
        ];

        /**
         * Réprésente le __construct de ce trait
         */
        public function traitElevesUtilConstruct()
        {
            $this->locales = \locales('app')['eleves'];
        }
    }
    
