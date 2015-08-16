<?php
use Phalcon\Mvc\Controller;

class IndexController extends Controller
{

    public function indexAction()
    {
        echo "<h1>Hello!</h1>";
        foreach($_SERVER as $k => $v){
            echo $k . "=" . $v . "<br/>";
        }
    }
}