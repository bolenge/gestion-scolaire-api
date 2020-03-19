<?php

    namespace App\Controllers;

    use Ekolo\Framework\Bootstrap\Controller;
    use Ekolo\Framework\Http\Request;
    use Ekolo\Framework\Http\Response;

    use App\Utils\MediasUtil;
    use App\Repositories\MediasRepository;

    class MediasController extends Controller {

        use MediasUtil;
        use MediasRepository;

        protected $traitsContructs = [
            'traitMediasRepositoryContruct',
            'traitMediasUtilContruct'
        ];

        /**
         * Permet de faire l'upload d'un média
         * 
         * @OA\Post(
         *      path="/medias/upload",
         *      tags={"Medias"},
         *      @OA\RequestBody(ref="#/components/requestBodies/createMediaRequest"),
         *      @OA\Response(
         *          response="200",
         *          ref="#/components/responses/SuccessResponse"
         *      ),
         *      @OA\Response(
         *          response="404",
         *          ref="#/components/responses/NotFoundResponse"
         *      )
         * )
         */
        public function upload(Request $request, Response $response)
        {
            if ($upload = $this->uploadFile($request->files()->get('media'))) {
                if ($upload['success']) {
                    if (!empty($media = $this->model->add($upload['data']))) {
                        $this->objetRetour['success'] = true;
                        $this->objetRetour['message'] = $this->locales['create']['success'];
                        $this->objetRetour['results'] = $media;
                    }else {
                        session()->set('errors', [
                            'warning' => $this->locales['create']['warning']
                        ]);
                    }
                }else {
                    session()->set('errors', [
                        'warning' => $upload['message']
                    ]);
                }
            }else {
                session()->set('errors', [
                    'warning' => $this->locales['create']['warning']
                ]);
            }

            $this->trackErrors();
            $response->json($this->objetRetour);
        }

    }