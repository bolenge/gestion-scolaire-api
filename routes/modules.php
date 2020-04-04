<?php

    use Ekolo\Component\Routing\Router;
    use Ekolo\Framework\Http\Response;
    use Ekolo\Framework\Http\Request;
    
    $router = new Router;

    $router->post('/createModule', 'ModulesController@createModule');
    $router->put('/updateModule/:id', 'ModulesController@updateModule');
    $router->put('/activeModule/:id', 'ModulesController@activeModule');
    $router->delete('/desactiveModule/:id', 'ModulesController@desactiveModule');
    $router->get('/getModuleById/:id', 'ModulesController@getModuleById');
    $router->get('/getListModules/:limit/:offset', 'ModulesController@getListModules');
    $router->get('/getListModules', 'ModulesController@getListModules');

    return $router;