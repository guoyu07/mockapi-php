<?php
use Phalcon\Mvc\Controller;

class IndexController extends Controller
{

    public function indexAction()
    {
        echo "<h1>Hello!</h1>";

        $rules = Rule::find();
        if($rules){
            foreach($rules as $rule){
                echo sprintf('id=%s url=%s', $rule->_id, $rule->url ) . "<br/>";
            }
        }
    }
}