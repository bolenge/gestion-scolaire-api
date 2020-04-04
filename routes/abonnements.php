<?php

    use Ekolo\Component\Routing\Router;
    use Ekolo\Framework\Http\Response;
    use Ekolo\Framework\Http\Request;
    
    $router = new Router;

    $router->post('/createAbonnement', 'AbonnementsController@createAbonnement');
    $router->put('/updateAbonnement/:id', 'AbonnementsController@updateAbonnement');
    $router->put('/activeAbonnement/:id', 'AbonnementsController@activeAbonnement');
    $router->delete('/desactiveAbonnement/:id', 'AbonnementsController@desactiveAbonnement');
    $router->get('/getAbonnementById/:id', 'AbonnementsController@getAbonnementById');
    $router->get('/getListAbonnements/:limit/:offset', 'AbonnementsController@getListAbonnements');
    $router->get('/getListAbonnements', 'AbonnementsController@getListAbonnements');
    $router->put('/beginEcoleAbonnement/:id/:id_ecole', 'AbonnementsController@beginEcoleAbonnement');
    
    return $router;