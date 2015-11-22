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
        header("Content-type: text/html; charset=utf-8");
        switch($pageService->getReturnType()){
            case BasePageService::RETURN_TYPE_JSON:
                $cbk = $this->request->get('callback');
                if($cbk){
                    echo $cbk . '(' . json_encode($pageService->getReturnData()) . ');';
                }else{
                    echo json_encode($pageService->getReturnData());
                }
                break;
            default :
                echo $pageService->getReturnData();
        }
    }
}