<?php

    namespace App\Controllers;

    use Ekolo\Framework\Bootstrap\Controller;
    use Ekolo\Framework\Http\Request;
    use Ekolo\Framework\Http\Response;

    class PersonnelsController extends Controller {

        public function index(Request $request, Response $response)
        {
            $response->render('users.liste', [
                'title' => 'Liste des utilisteurs'
            ]);
        }

    }