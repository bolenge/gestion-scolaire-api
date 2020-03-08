<?php

    use Ekolo\Component\Routing\Router;
    use Ekolo\Framework\Http\Response;
    use Ekolo\Framework\Http\Request;
    
    $router = new Router;

    $router->post('/login', 'AdminsController@login');
    $router->get('/getAdminInfos/:id', 'AdminsController@getAdminInfos');

    return $router;