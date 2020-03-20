<?php

    use Ekolo\Component\Routing\Router;
    use Ekolo\Framework\Http\Response;
    use Ekolo\Framework\Http\Request;
    
    $router = new Router;

    $router->post('/createPersonnel', 'PersonnelsController@createPersonnel');
    $router->put('/updatePersonnel/:id', 'PersonnelsController@updatePersonnel');
    $router->put('/activePersonnel/:id', 'PersonnelsController@activePersonnel');
    $router->delete('/desactivePersonnel/:id', 'PersonnelsController@desactivePersonnel');

    return $router;