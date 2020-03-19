<?php

    use Ekolo\Component\Routing\Router;
    use Ekolo\Framework\Http\Response;
    use Ekolo\Framework\Http\Request;
    
    $router = new Router;

    $router->post('/createActeur', 'ActeursController@createActeur');
    $router->post('/login', 'ActeursController@login');
    $router->get('/getActeurInfos/:id', 'ActeursController@getActeurInfos');
    $router->put('/updateActeur/:id', 'ActeursController@updateActeur');

    return $router;