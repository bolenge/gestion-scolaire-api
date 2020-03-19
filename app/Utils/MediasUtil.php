<?php

    namespace App\Utils;

    use OpenApi\Annotations as OA;
    use App\Utils\Util;

    
    trait MediasUtil
    {
        use Util;

        /**
         * @OA\RequestBody(
         * 		request="createMediaRequest",
         * 		description="Les données à renseigner",
         *		required=true,
         *      @OA\MediaType(
         *          mediaType="multipart/form-data",
         *          @OA\Schema(
         *              required={"media"},
         *              @OA\Property(
         *                  property="media",
         *                  description="Le fichier à uploader",
         *                  type="file",
         *                  @OA\Items(type="string", format="binary")
         *               )
         *           )
         *      )
         * )
         * @var array
         */
        protected $rules = [
            
        ];

        /**
         * Réprésente le __construct de ce trait
         */
        public function traitMediasUtilContruct()
        {
            $this->locales = \locales('app')['medias'];
        }
    }
    
