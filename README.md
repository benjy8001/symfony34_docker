Exchange plateform with Symfony 3.4
========

Based on Openclassroom course.


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

