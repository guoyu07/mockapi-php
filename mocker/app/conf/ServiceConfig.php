<?php
use Phalcon\Mvc\View;
use Phalcon\Mvc\Url as UrlProvider;
use Phalcon\Mvc\Collection\Manager as CollectionManager;

class ServiceConfig
{
    public static function register($di)
    {
        // Setup the view component
        $di->set('view', function () {
            $view = new View();
            $view->setViewsDir('../app/views/');
            return $view;
        });

        $di->set('mongo', function () {
            $mongo = new MongoClient(DatabaseConfig::$mongo['address']);
            return $mongo->selectDB(DatabaseConfig::$mongo['db']);
        }, true);

        $di->set('collectionManager', function () {
            return new CollectionManager();
        }, true);
    }
}