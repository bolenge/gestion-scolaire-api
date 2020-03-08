<?php

    use Ekolo\Component\Routing\Router;
    use Ekolo\Framework\Http\Response;
    use Ekolo\Framework\Http\Request;
    
    $router = new Router;
    
    $router->post('/createEcole', 'EcolesController@createEcole');
    $router->put('/updateEcole/:id', 'EcolesController@updateEcole');
    $router->delete('/desactiveEcole/:id', 'EcolesController@desactiveEcole');
    $router->put('/activeEcole/:id', 'EcolesController@activeEcole');

    return $router;