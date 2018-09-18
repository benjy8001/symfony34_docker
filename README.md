Exchange plateform with Symfony 3.4
========

Based on Openclassroom course.

Setup
-----

Edit `webapp/www/app/config/parameters.yml`

```
parameters:
    database_host: database
    database_port: 5432
    database_name: symfony_db
    database_user: symfony_user
    database_password: symfony_password
    mailer_transport: smtp
    mailer_host: 127.0.0.1
    mailer_user: lorem@ipsum.fr
    mailer_password: null
    secret: ThisTokenIsNotSoSecretChangeIt

```

Build
-----

	$ docker-compose up --build -d

Stop
-----

	$ docker-compose down

Connect to containers
-----

	$ docker exec -ti application /bin/bash
	$ docker exec -ti h2-proxy sh
	$ docker exec -ti cache-proxy sh


Tests
-----

	$ https://localhost -> Access throught nginx reverse proxy (add SSL support)
	$ http://localhost:8081 -> Access throught varnish cache
	$ http://localhost:3000 -> Direct access to webapp
	$ http://localhost:8080 -> Access to Adminer pgsql admin

Add app_dev.php in URL in order to activate debug with symfony webapp.

Some fixes
-----	

## In composer.json :

```
    "autoload": {
        "psr-4": {
            "AppBundle\\": "src/AppBundle",
            "OC\\PlatformBundle\\": "src/OC/PlatformBundle"
        },
```

## In src/OC/PlatformBundel/Controller/DefaultController.php :


`return $this->render('@OCPlatform/Default/index.html.twig');`	

Instead of :

`return $this->render('OCPlatformBundle:Default:index.html.twig');`


TODO :
Add spinner overlay until loading end.
Add unit tests.

