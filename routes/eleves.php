<?php

    use Ekolo\Component\Routing\Router;
    use Ekolo\Framework\Http\Response;
    use Ekolo\Framework\Http\Request;
    
    $router = new Router;

    $router->post('/createEleve', 'ElevesController@createEleve');
    $router->put('/updateEleve/:id', 'ElevesController@updateEleve');
    $router->put('/desactiveEleve/:id', 'ElevesController@desactiveEleve');
    $router->put('/activeEleve/:id', 'ElevesController@activeEleve');
    $router->delete('/deleteEleve/:id', 'ElevesController@deleteEleve');
    $router->put('/restoreEleve/:id', 'ElevesController@restoreEleve');
    $router->get('/getListEleves/:limit/:offset', 'ElevesController@getListEleves');
    $router->get('/getListEleves', 'ElevesController@getListEleves');
    $router->get('/getEleveById/:id', 'ElevesController@getEleveById');

    return $router;