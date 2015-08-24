<?php
use Phalcon\Mvc\Controller;

class RuleController extends Controller
{

    public function indexAction()
    {
        echo 'hello';
    }

    public function listAction($params=null)
    {
        echo 'list ';
    }

    public function addAction($params=null)
    {
        echo 'add ' . var_export($params, true);
    }

    public function removeAction($params=null)
    {
        echo 'remove ' . var_export($params, true);
    }

    public function modifyAction($params=null)
    {
        echo 'modify ' . var_export($params, true);
    }
}
