<?php

    use Ekolo\Component\Routing\Router;
    use Ekolo\Framework\Http\Response;
    use Ekolo\Framework\Http\Request;
    
    $router = new Router;

    $router->post('/createSousModule', 'SousModulesController@createSousModule');
    $router->put('/updateSousModule/:id', 'SousModulesController@updateSousModule');
    $router->put('/activeSousModule/:id', 'SousModulesController@activeSousModule');
    $router->delete('/desactiveSousModule/:id', 'SousModulesController@desactiveSousModule');
    $router->get('/getSousModuleById/:id', 'SousModulesController@getSousModuleById');
    $router->get('/getListSousModules/:limit/:offset', 'SousModulesController@getListSousModules');
    $router->get('/getListSousModules', 'SousModulesController@getListSousModules');

    return $router;