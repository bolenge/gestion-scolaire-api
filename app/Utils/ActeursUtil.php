<?php

    namespace App\Utils;

    use OpenApi\Annotations as OA;
    use App\Utils\Util;

    
    trait ActeursUtil
    {
        use Util;

        /**
         * @OA\RequestBody(
         * 		request="createActeurRequest",
         * 		description="Les données à renseigner",
         *		required=true,
         *      @OA\MediaType(
         *      	mediaType="application/x-www-form-urlencoded",
         *          @OA\Schema(
         *          	type="object",
         *				required={"nom", "email", "sexe"},
         *              @OA\Property(type="string", property="nom"),
         *              @OA\Property(type="string", property="sexe"),
         *              @OA\Property(type="string", property="email"),
         *              @OA\Property(type="string", property="prenom"),
         *              @OA\Property(type="string", property="postnom"),
         *              @OA\Property(type="string", property="telephone"),
         *              @OA\Property(type="string", property="etat_civil"),
         *              @OA\Property(type="integer", property="id_adresse"),
         *              @OA\Property(type="integer", property="id_media_avatar")
         *         )
         *     )
         * )
         * 
         * @var array
         */
        protected $rulesCreating = [
            'nom' => 'required|min:3|max:100|alpha',
            'sexe' => 'required|alpha:1',
            'email' => 'required|email',
            'prenom' => 'min:3|max:100|alpha',
            'postnom' => 'min:3|max:100|alpha',
            'telephone' => 'tel|min:10|max:16',
            'etat_civil' => 'min:3|max:100|alpha',
            'id_adresse' => 'int',
            'id_media_avatar' => 'int'
        ];

        /**
         * Les r$oles réconnus
         * @var array
         */
        protected $sexes = ['M', 'F', 'Autre'];

        /**
         * Réprésente le __construct de ce trait
         */
        public function traitActeursUtilContruct()
        {
            $this->locales = \locales('app')['acteurs'];
        }
    }
    
