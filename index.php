<?php
    $app = require __DIR__.'/bootstrap/app.php';

    use Ekolo\Framework\Bootstrap\Middleware;

    $users = require './routes/users.php';

    $app->middleware('errors', function (Middleware $middleware) {
        $middleware->getError();
    });
    
    $app->use('/', $users);