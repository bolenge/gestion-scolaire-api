<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= !empty($title) ? $title : 'API Gestion scolaire' ?></title>
        <style>
            .container {
                text-align: center;
                font-family: Calibri Light, sans-serif;
                width: 50%;
                margin: 0 auto;
            }

            .p-logo {
                margin-bottom: 50px;
                margin-top: 40px;
            }

            footer {
                margin-top: 100px;
                background-color: rgba(220, 220, 220, 0.219);
                padding: 20px;
            }
        </style>
    </head>
    <body>
        <?= $content ?>
    </body>
</html>