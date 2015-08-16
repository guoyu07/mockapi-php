<?php
use Phalcon\Loader;
use Phalcon\Mvc\Application;
use Phalcon\DI\FactoryDefault;

define('APP_PATH', realpath('..') . '/');

try {

    // Register an autoloader
    $loader = new Loader();
    $loader->registerDirs(array(
        APP_PATH . 'app/controllers/',
        APP_PATH . 'app/models/',
        APP_PATH . 'app/conf/',
    ))->register();

    // Create a DI
    $di = new FactoryDefault();
    // Register Services
    ServiceConfig::register($di);
    // Handle the request
    $application = new Application($di);

    echo $application->handle()->getContent();

} catch (Exception $e) {
    echo "PhalconException: ", $e->getMessage();
}