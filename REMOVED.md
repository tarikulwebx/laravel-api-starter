I have changed the following files and folders for Laravel REST API only starter:

### Removed Files and Folders:

-   vite.config.js
-   package.json
-   resources/views/welcome.blade.php
-   resources/js
-   resources/css
-   routes/web.php

### Changed Files

#### bootstrap/app.php

```diff
 return Application::configure(basePath: dirname(__DIR__))
     ->withRouting(
-        web: __DIR__.'/../routes/web.php',
         commands: __DIR__.'/../routes/console.php',
         health: '/up',
     )
```

#### composer.json

```diff
    "scripts": {
        "setup": [
            "composer install",
            "@php -r \"file_exists('.env') || copy('.env.example', '.env');\"",
            "@php artisan key:generate",
            "@php artisan migrate --force",
-            "npm install",
-            "npm run build"
        ],
        "dev": [
            "Composer\\Config::disableProcessTimeout",
-            "npx concurrently -c \"#93c5fd,#c4b5fd,#fdba74\" \"php artisan serve\" \"php artisan queue:listen --tries=1\" \"npm run dev\" --names='server,queue,vite'",
+            "php artisan serve",
+            "php artisan queue:listen --tries=1"
        ],
        ...
    }
```
