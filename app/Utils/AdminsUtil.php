<?php

    namespace App\Utils;

    use OpenApi\Annotations as OA;
    use App\Utils\Util;

    
    trait AdminsUtil
    {
        use Util;

        /**
         * Les règles sur des requêtes qu'on peut bien lancer
         * 
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
        protected $rules = [
            'username' => 'required|min:3|max:100|alpha',
            'password' => 'required|min:6'
        ];
    }
    
