<?php
use Phalcon\Mvc\Controller;

/**
 * Class BaseController
 */
class BaseController extends Controller
{
    /**
     * äÖÈ¾Êı¾İ
     * @param BasePageService $pageService
     */
    public function render($pageService){
        if($pageService instanceof JsonPageService){
            echo json_encode($pageService->getReturnData());
        }else{
            echo $pageService->getReturnData();
        }
    }
}