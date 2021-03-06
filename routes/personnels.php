<?php

    use Ekolo\Component\Routing\Router;
    use Ekolo\Framework\Http\Response;
    use Ekolo\Framework\Http\Request;
    
    $router = new Router;

    $router->post('/createPersonnel', 'PersonnelsController@createPersonnel');
    $router->put('/updatePersonnel/:id', 'PersonnelsController@updatePersonnel');
    $router->put('/activePersonnel/:id', 'PersonnelsController@activePersonnel');
    $router->delete('/desactivePersonnel/:id', 'PersonnelsController@desactivePersonnel');
    $router->get('/getListPersonnels/:limit/:offset', 'PersonnelsController@getListPersonnels');
    $router->get('/getListPersonnels', 'PersonnelsController@getListPersonnels');
    $router->get('/getPersonnelById/:id', 'PersonnelsController@getPersonnelById');

    // Personnels gérants
    $router->post('/gerants/createPersonnelGerant', 'PersonnelsGerantsController@createPersonnelGerant');
    $router->post('/gerants/loginPersonnelGerant', 'PersonnelsGerantsController@loginPersonnelGerant');
    $router->put('/gerants/setPersonnelGerantAvatar', 'PersonnelsGerantsController@setPersonnelGerantAvatar');
    $router->put('/gerants/setPersonnelGerantPassword', 'PersonnelsGerantsController@setPersonnelGerantPassword');
    $router->put('/gerants/updatePersonnelGerant', 'PersonnelsGerantsController@updatePersonnelGerant');

    return $router;