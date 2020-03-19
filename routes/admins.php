<?php

    use Ekolo\Component\Routing\Router;
    use Ekolo\Framework\Http\Response;
    use Ekolo\Framework\Http\Request;
    
    $router = new Router;

    $router->get('/getAdminById/:id', 'AdminsController@getAdminById');
    $router->post('/login', 'AdminsController@login');
    $router->post('/createAdmin', 'AdminsController@createAdmin');
    $router->put('/updateAdmin/:id', 'AdminsController@updateAdmin');
    $router->put('/activeAdmin/:id', 'AdminsController@activeAdmin');
    $router->delete('/desactiveAdmin/:id', 'AdminsController@desactiveAdmin');
    $router->get('/getListAdmins/:limit/:offset', 'AdminsController@getListAdmins');
    $router->get('/getListAdmins', 'AdminsController@getListAdmins');
    $router->post('/logout/:id', 'AdminsController@logout');

    return $router;