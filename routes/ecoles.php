<?php

    use Ekolo\Component\Routing\Router;
    use Ekolo\Framework\Http\Response;
    use Ekolo\Framework\Http\Request;
    
    $router = new Router;
    
    $router->post('/createEcole', 'EcolesController@createEcole');
    $router->put('/updateEcole/:id', 'EcolesController@updateEcole');
    $router->put('/activeEcole/:id', 'EcolesController@activeEcole');
    $router->delete('/desactiveEcole/:id', 'EcolesController@desactiveEcole');
    $router->get('/getEcoleById/:id', 'EcolesController@getEcoleById');
    $router->get('/getAllEcoles/:limit/:offset', 'EcolesController@getAllEcoles');
    $router->get('/getAllEcoles', 'EcolesController@getAllEcoles');

    return $router;