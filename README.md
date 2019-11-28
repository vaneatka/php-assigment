## Symfony 4 PHP Assignment

To use this app you should clone it and run **composer install**

You should have `docker` installed on your PC

### How to setup work environment
* Install `docker` and `docker-compose`, (https://docs.docker.com/)
* Run `docker-compose up`
* Access in your favorite browser http://localhost:8000


Note: Current version of `docker-compose.yml` contain 3 images, 
* php7.3-alpine with some plugins, it also run the server (https://www.php.net/manual/en/features.commandline.webserver.php)
* phpMyAdmin which will be available on http://localhost:8080
* mysql database which will be used by app

This app uses Symfony Messenger package for handling the file processing, 
to consume the queue you can run `php bin/console messenger:consume async -vv`

### Behat testing
To run a behat test, you should run `php vendor/bin/behat` in console.

### Unit tests
To run PHPUnit, run in console `php vendor/bin/simple-phpunit`

### Contribution
Feel free to contribute into this project. New tasks and kata are welcome.

