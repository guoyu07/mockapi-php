<?php
use Phalcon\Mvc\Controller;

class IndexController extends Controller
{

    public function indexAction()
    {
        //echo "<h1>Hello!</h1>";
        //$params = array_merge($_GET, $_POST);
        $url=$_SERVER['DOCUMENT_URI'];
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
            }
        }else{
            echo '{"error":1, "msg":"can\'t match any url"}';
        }
    }
}
