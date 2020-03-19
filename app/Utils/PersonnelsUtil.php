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
         *              @OA\Property(type="integer", property="id_acteur"),
         *              @OA\Property(type="integer", property="id_ecole"),
         *         )
         *     )
         * )
         * 
         * @var array
         */
        protected $rulesCreating = [
            'id' => 'int',
            'role' => 'required|min:3|max:100|alpha',
            'username' => 'required|min:3|max:100|alpha',
            'password' => 'required|min:6|alpha',
            'id_acteur' => 'required|int',
            'id_media_avatar' => 'int'
        ];

        /**
         * Les r$oles réconnus
         * @var array
         */
        protected $roles = [
            'super-admin',
            'simple-admin'
        ];

        /**
         * Réprésente le __construct de ce trait
         */
        public function traitAdminsUtilContruct()
        {
            $this->locales = \locales('app')['admins'];
        }
    }
    
