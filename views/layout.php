<!-- HTML for static distribution bundle build -->
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <title><?= !empty($title) ? $title : 'API Gestion scolaire' ?></title>
    <link rel="stylesheet" type="text/css" href="/public/docs/swagger-ui.css" >
    <link rel="icon" type="image/png" href="/public/docs/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="/public/docs/favicon-16x16.png" sizes="16x16" />
    <style>
        html
        {
            box-sizing: border-box;
            overflow: -moz-scrollbars-vertical;
            overflow-y: scroll;
        }

        *,
        *:before,
        *:after
        {
            box-sizing: inherit;
        }

        body
        {
            margin:0;
            background: #fafafa;
        }
    </style>
  </head>

  <body>
    <?= $content ?>

    <script src="/public/docs/swagger-ui-bundle.js"> </script>
    <script src="/public/docs/swagger-ui-standalone-preset.js"> </script>
    <script>
    window.onload = function() {
      // Begin Swagger UI call region
      const ui = SwaggerUIBundle({
        url: "/public/docs/api.json",
        dom_id: '#swagger-ui',
        deepLinking: true,
        presets: [
          SwaggerUIBundle.presets.apis,
          SwaggerUIStandalonePreset
        ],
        plugins: [
          SwaggerUIBundle.plugins.DownloadUrl
        ],
        layout: "StandaloneLayout"
      })
      // End Swagger UI call region

      window.ui = ui
    }
  </script>
  </body>
</html>
