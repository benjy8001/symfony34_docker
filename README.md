Exchange plateform with Symfony 3.4
========

Based on Openclassroom course.


Build
-----

	$ docker-compose up --build -d
	$ docker-compose down

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
Use of Doctrine migration.
Add spinner overlay until loading end.
Add unit tests.
Add webpack for testing.
Add varnish docker image.