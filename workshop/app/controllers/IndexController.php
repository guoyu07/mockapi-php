<?php
use Phalcon\Mvc\Controller;

class IndexController extends Controller
{

    public function indexAction()
    {
        $url = explode('?', $_SERVER['REQUEST_URI'])[0];
        $rules = Rule::find(array(
            array(
                'url'=> $url,
            )
        ));
        if($rules){
            foreach($rules as $rule){
                if(is_array($rule->res) || is_object($rule->res)){
                    echo json_encode($rule->res);
                }else{
                    echo $rule->res;
                }
                break;
            }
        }else{
            echo json_encode(array(
                'error' => 1,
                'msg' => 'can\'t match any url for [' . $url . ']',
            ));
        }
    }

}
