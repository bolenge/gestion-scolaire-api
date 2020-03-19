<?php
    $app = require __DIR__.'/bootstrap/app.php';

    use Ekolo\Framework\Bootstrap\Middleware;

    // Loading of routes
    $users   = require './routes/users.php';
    $admins  = require './routes/admins.php';
    $apps    = require './routes/apps.php';
    $ecoles  = require './routes/ecoles.php';
    $acteurs = require './routes/acteurs.php';
    $medias  = require './routes/medias.php';
    $personnels  = require './routes/personnels.php';

    // Middlewares
    $app->middleware('errors', function (Middleware $middleware) {
        $middleware->getError();
    });
    
    // Using routes
    $app->use('/', $apps);
    $app->use('/admins', $admins);
    $app->use('/ecoles', $ecoles);
    $app->use('/acteurs', $acteurs);
    $app->use('/medias', $medias);
    $app->use('/personnels', $personnels);