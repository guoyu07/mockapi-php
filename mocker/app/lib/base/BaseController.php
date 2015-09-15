<?php
use Phalcon\Mvc\Controller;

/**
 * Class BaseController
 */
class BaseController extends Controller
{
    /**
     * ��Ⱦ����
     * @param BasePageService $pageService
     */
    public function render($pageService){
        switch($pageService->getReturnType()){
            case BasePageService::RETURN_TYPE_JSON:
                echo json_encode($pageService->getReturnData());
                break;
            default :
                echo $pageService->getReturnData();
        }
    }
}