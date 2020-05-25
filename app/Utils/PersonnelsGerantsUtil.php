<?php

    namespace App\Utils;

    use OpenApi\Annotations as OA;
    use App\Utils\Util;

    
    trait PersonnelsGerantsUtil
    {
        use Util;

        /**
         * @OA\RequestBody(
         * 		request="createPersonnelGerantRequest",
         * 		description="Les données à renseigner",
         *		required=true,
         *      @OA\MediaType(
         *      	mediaType="application/x-www-form-urlencoded",
         *          @OA\Schema(
         *          	type="object",
         *				required={"id_ecole", "id_personnel", "id_abonnement", "id_sous_module", "role", "username", "password"},
         *              @OA\Property(type="string", property="id_ecole"),
         *              @OA\Property(type="string", property="id_personnel"),
         *              @OA\Property(type="string", property="id_abonnement"),
         *              @OA\Property(type="integer", property="id_sous_module"),
         *              @OA\Property(type="integer", property="role"),
         *              @OA\Property(type="integer", property="username"),
         *              @OA\Property(type="integer", property="password")
         *         )
         *     )
         * )
         * 
         * @var array
         */
        protected $rulesCreating = [
            'id' => 'int',
            'id_ecole' => 'required|int',
            'id_personnel' => 'required|int',
            'id_abonnement' => 'required|int',
            'id_sous_module' => 'required|int',
            'role' => 'required|min:3|max:200|alpha',
            'username' => 'required|min:3|max:200',
            'password' => 'required|min:6|alpha'
        ];

        /**
         * @OA\RequestBody(
         * 		request="loginPersonnelGerantRequest",
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
            'password' => 'required|min:6|alpha',
            'username' => 'required|alpha|min:2'
        ];

        /**
         * @OA\RequestBody(
         * 		request="setPersonnelGerantAvatarRequest",
         * 		description="Les données à renseigner",
         *		required=true,
         *      @OA\MediaType(
         *      	mediaType="application/x-www-form-urlencoded",
         *          @OA\Schema(
         *          	type="object",
         *				required={"id_personnel", "id_media_avatar"},
         *              @OA\Property(type="integer", property="id_personnel"),
         *              @OA\Property(type="integer", property="id_media_avatar")
         *         )
         *     )
         * )
         */
        protected $rulesSetAvatar = [
            'id_personnel' => 'required|int',
            'id_media_avatar' => 'required|int'
        ];

        /**
         * @OA\RequestBody(
         * 		request="setPersonnelGerantPasswordRequest",
         * 		description="Les données à renseigner",
         *		required=true,
         *      @OA\MediaType(
         *      	mediaType="application/x-www-form-urlencoded",
         *          @OA\Schema(
         *          	type="object",
         *				required={"username", "password", "new_password"},
         *              @OA\Property(type="string", property="username"),
         *              @OA\Property(type="string", property="password"),
         *              @OA\Property(type="string", property="new_password")
         *         )
         *     )
         * )
         * 
         * @var array
         */
        protected $rulesSetPassword = [
            'username' => 'required|alpha|min:2',
            'password' => 'required|min:6|alpha',
            'new_password' => 'required|min:6|alpha'
        ];

        /**
         * Réprésente le __construct de ce trait
         */
        public function traitPersonnelsGerantsUtilConstruct()
        {
            $this->locales = \locales('app')['personnels'];
        }
    }
    
