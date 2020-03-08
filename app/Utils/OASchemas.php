<?php
    namespace App\Utils;

    use OpenApi\Annotations as OA;

    class OASchemas {

        /**
         * @OA\Parameter(
         *      name="id",
         *      in="path",
         *      description="ID de la ressource",
         *      required=true,
         *      @OA\Schema(type="integer")
         * )
         * 
         * 
         * @OA\Response(
         *      response="NotFoundResponse",
         *      description="La ressource n'existe pas",
         *      @OA\JsonContent(
         *          @OA\Property(property="message", type="string", example="La ressource n'existe pas")
         *      )
         * )
         * 
         * @OA\Response(
         *      response="SuccessResponse",
         *      description="La ressource n'existe pas",
         *      @OA\JsonContent(ref="#/components/schemas/objetRetour")
         * )
         */
        protected $id;
        

    }