<?php

    use Ekolo\Component\Routing\Router;
    use Ekolo\Framework\Http\Response;
    use Ekolo\Framework\Http\Request;
    
    $router = new Router;

    $router->get('/', 'ApplicationsController@index');
    $router->get('/docs', 'ApplicationsController@docs');

    return $router;