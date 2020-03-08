<?php
    $app = require __DIR__.'/bootstrap/app.php';

    use Ekolo\Framework\Bootstrap\Middleware;

    $users = require './routes/users.php';
    $admins = require './routes/admins.php';
    $apps = require './routes/apps.php';
    $ecoles = require './routes/ecoles.php';

    $app->middleware('errors', function (Middleware $middleware) {
        $middleware->getError();
    });
    
    $app->use('/', $apps);
    $app->use('/admins', $admins);
    $app->use('/ecoles', $ecoles);