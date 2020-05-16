<?php

    namespace App\Middleware;

    use Ekolo\Framework\Bootstrap\Middleware;
    use Ekolo\Framework\Http\Request;
    use Ekolo\Framework\Http\Response;

    /**
     * @package class
     * @description Auth les applications externes utilisant cette API
     * @author Don de Dieu Bolenge <dondedieubolenge@gmail.com>
     */
    class AuthAppMiddleware extends Middleware
    {
        /**
         * Concerne les authorisation à des applications externces
         * @return void
         */
        public function authorize()
        {
            $this->response->addHeaders([
                'Access-Control-Allow-Origin: *'
            ]);
        }
    }
    