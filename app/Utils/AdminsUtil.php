<?php

    namespace App\Utils;

    use OpenApi\Annotations as OA;
    use App\Utils\Util;

    
    trait AdminsUtil
    {
        use Util;

        /**
         * @OA\RequestBody(
         * 		request="adminLogin",
         * 		description="Les données à renseigner",
         *		required=true,
         *      @OA\MediaType(
         *      	mediaType="application/x-www-form-urlencoded",
         *          @OA\Schema(
         *          	type="object",
         *				required={"username", "password"},
         *              @OA\Property(type="string", property="username"),
         *              @OA\Property(type="string", property="password")
         *         )
         *     )
         * )
         * 
         * @var array
         */
        protected $rulesLogin = [
            'username' => 'required|min:3|max:100|alpha',
            'password' => 'required|min:6|alpha'
        ];

        /**
         * @OA\RequestBody(
         * 		request="createAdminRequest",
         * 		description="Les données à renseigner",
         *		required=true,
         *      @OA\MediaType(
         *      	mediaType="application/x-www-form-urlencoded",
         *          @OA\Schema(
         *          	type="object",
         *				required={"username", "password", "id_acteur", "role"},
         *              @OA\Property(type="string", property="role"),
         *              @OA\Property(type="string", property="username"),
         *              @OA\Property(type="string", property="password"),
         *              @OA\Property(type="integer", property="id_acteur"),
         *         )
         *     )
         * )
         * 
         * @var array
         */
        protected $rulesCreating = [
            'id' => 'required|int',
            'role' => 'required|min:3|max:100|alpha',
            'username' => 'required|min:3|max:100|alpha',
            'password' => 'required|min:6|alpha',
            'id_acteur' => 'required|int'
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
    
