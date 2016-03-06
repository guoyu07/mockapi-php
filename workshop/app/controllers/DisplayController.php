<?php
use Phalcon\Config\Adapter\Ini as ConfigIni;
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
        $url = $this->request->get('url');
        $config = new ConfigIni(APP_PATH . "app/conf/mocker.ini");
        header('location:' . $config->mocker->url . $url);
        $this->view->disable();
    }
}