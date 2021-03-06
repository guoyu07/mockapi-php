<?php
use Phalcon\Loader;
use Phalcon\Mvc\Application;
use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\Router;

define('APP_PATH', realpath('..') . '/');

try {

    // Register an autoloader
    $loader = new Loader();
    $loader->registerDirs(array(
        APP_PATH . 'app/controllers/',
        APP_PATH . 'app/models/',
        APP_PATH . 'app/conf/',
        APP_PATH . 'app/lib/base/',
        APP_PATH . 'app/lib/const/',
        APP_PATH . 'app/lib/util/',
        APP_PATH . 'app/service/page/',
        APP_PATH . 'app/service/data/',
        APP_PATH . 'app/service/data/evaluator/',
        APP_PATH . 'app/service/data/evaluator/impl/',
    ))->register();

    // Create a DI
    $di = new FactoryDefault();
    // Register Services
    ServiceConfig::register($di);
    $di->set('router', function(){
        // Create the router without default routes
        $router = new Router(false);
        $router->add(
            "/",
            array(
                'controller' => 'index',
                'action'     => 'index'
            )
        );
        $router->notFound(
            array(
                "controller" => "index",
                "action"     => "index"
            )
        );
        return $router;
    });
    // Handle the request
    $application = new Application($di);

    echo $application->handle()->getContent();

} catch (Exception $e) {
    echo "PhalconException: ", $e->getMessage();
}