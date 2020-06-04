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
    $modules  = require './routes/modules.php';
    $sous_modules  = require './routes/sous_modules.php';
    $abonnements  = require './routes/abonnements.php';
    $eleves  = require './routes/eleves.php';

    // Middlewares
    $app->middleware('errors', function (Middleware $middleware) {
        $middleware->getError();
    });
    $app->middleware('authApp', function (Middleware $authApp) {
        $authApp->authorize();
    });
    
    // Using routes
    $app->use('/', $apps);
    $app->use('/admins', $admins);
    $app->use('/ecoles', $ecoles);
    $app->use('/acteurs', $acteurs);
    $app->use('/medias', $medias);
    $app->use('/personnels', $personnels);
    $app->use('/modules', $modules);
    $app->use('/sousModules', $sous_modules);
    $app->use('/abonnements', $abonnements);
    $app->use('/eleves', $eleves);