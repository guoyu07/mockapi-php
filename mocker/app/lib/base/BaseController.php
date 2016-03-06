<?php
use Phalcon\Mvc\Controller;
use \Phalcon\Mvc\View;

/**
 * Class BaseController
 */
class BaseController extends Controller
{
    /**
     * 渲染数据
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
                $this->view->disable();
                $this->view->setRenderLevel(View::LEVEL_NO_RENDER);
                break;
            default :
                echo $pageService->getReturnData();
        }
    }
}