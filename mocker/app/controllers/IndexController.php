<?php
/**
 * Class IndexController
 */
class IndexController extends BaseController
{

    public function indexAction()
    {
        $url = explode('?', $_SERVER['REQUEST_URI'])[0];
        $pageService = new IndexPageService($this->request, $this->response);
        $pageService->setUrl($url);
        $pageService->execute();
        $this->render($pageService);
    }
}
