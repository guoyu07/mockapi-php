<?php
/**
 * Class DisplayController
 */
class DisplayController extends BaseController
{
    public function indexAction()
    {
        $this->view->pick('display/list');
    }

    public function listAction()
    {

    }

    public function addAction()
    {

    }

    public function editAction()
    {

    }

    public function previewAction(){
        $config = $this->di->get('config');
        $url = $this->request->get('url');
        header('location:' . $config->mocker->url . $url);
        $this->view->disable();
    }
}