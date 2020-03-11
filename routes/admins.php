<?php

    use Ekolo\Component\Routing\Router;
    use Ekolo\Framework\Http\Response;
    use Ekolo\Framework\Http\Request;
    
    $router = new Router;

    $router->get('/getAdminById/:id', 'AdminsController@getAdminById');
    $router->post('/login', 'AdminsController@login');
    $router->post('/createAdmin', 'AdminsController@createAdmin');
    $router->put('/updateAdmin/:id', 'AdminsController@updateAdmin');

    return $router;