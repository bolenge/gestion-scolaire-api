<?php

    namespace App\Utils;

    use OpenApi\Annotations as OA;
    use Ekolo\Framework\Bootstrap\Model;
    use App\Utils\UploadFile;

    /**
     * Util principal
     */
    trait Util
    {
        /**
         * Le locale des fonctionnalités d'un module
         * @var array
         */
        protected $locales;

        /**
         * @OA\Schema(
         *      schema="objetRetour",
         *      description="Objet retour de résultats uax requêtes",
         *      @OA\Property(type="boolean", property="success"),
         *      @OA\Property(type="string", property="message"),
         *      @OA\Property(type="object", property="errors"),
         *      @OA\Property(type="object", property="results")
         * )
         */
        protected $objetRetour = [
            'success' => false,
            'message' => '',
            'errors' => null,
            'results' => null
        ];

        /**
         * Réprésente le __construct de ce trait
         */
        public function utilConstruct()
        {
            // debug("Le __contruct du trait est lancé");
        }

        /**
         * Permet de traquer les erreurs
         * @return void
         */
        public function trackErrors()
        {
            if (session()->has('errors')) {
                $errors = session('errors');
                $this->objetRetour['errors'] = $errors;

                if (empty($this->objetRetour['message'])) {
                    $errorsValues = array_values($errors);
                    $this->objetRetour['message'] = \implode('<br/>', $errorsValues);
                }
                
                session()->remove('errors');
            }
        }

        /**
         * Permet d'uploader un fichier
         * @param array $file
         * @return array
         */
        public function uploadFile(array $file)
        {
            $uploadFile = new UploadFile($file);
            return $uploadFile->upload();
        }
    }
    
