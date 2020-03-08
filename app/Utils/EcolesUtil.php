<?php

    namespace App\Utils;

    use OpenApi\Annotations as OA;
    use App\Utils\Util;
    use App\Models\EcolesModel;
    
    trait EcolesUtil
    {
        use Util;
        
        /**
         * @OA\RequestBody(
         * 		request="ecoleRequestBody",
         * 		description="Les données à renseigner pour la création d'une école",
         *		required=true,
         *      @OA\MediaType(
         *      	mediaType="application/x-www-form-urlencoded",
         *          @OA\Schema(
         *          	type="object",
         *				required={"nom", "telephone", "localite", "num_agrement"},
         *              @OA\Property(type="string", property="nom"),
         *              @OA\Property(type="email", property="email"),
         *              @OA\Property(type="url", property="website"),
         *              @OA\Property(type="tel", property="telephone"),
         *              @OA\Property(type="string", property="localite"),
         *              @OA\Property(type="string", property="num_agrement"),
         *              @OA\Property(type="integer", property="id_media_logo")
         *         )
         *     )
         * )
         * 
         * @var array
         */
        protected $rules = [
            'id' => 'int',
            'nom' => 'required|min:2|max:300|alpha',
            'email' => 'email',
            'website' => 'min:10|alpha',
            'localite' => 'required|min:3',
            'telephone' => 'required|tel|min:10|max:16',
            'num_agrement' => 'required|min:3',
            'id_media_logo' => 'int'
        ];

        /**
         * Réprésente le __construct de ce trait
         */
        public function traitEcolesUtilContruct()
        {
            $this->locales = \locales('app')['ecoles'];
        }
    }
    
