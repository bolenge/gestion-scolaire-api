<?php

    use Ekolo\Component\Routing\Router;
    use Ekolo\Framework\Http\Response;
    use Ekolo\Framework\Http\Request;
    
    $router = new Router;

    $router->post('/createEleve', 'ElevesController@createEleve');
    $router->put('/updateEleve/:id', 'ElevesController@updateEleve');

    return $router;