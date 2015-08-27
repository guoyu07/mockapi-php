<?php

class RuleController extends BaseController
{

    public function indexAction()
    {
        echo 'hello';
    }

    public function listAction()
    {
        $pageService = new ListRulePageService($this->request, $this->response);
        $pageService->execute();
        $this->render($pageService);
    }

    public function addAction()
    {
        $pageService = new AddRulePageService($this->request, $this->response);
        $pageService->execute();
        $this->render($pageService);
    }

    public function modifyAction()
    {
        $pageService = new ModifyRulePageService($this->request, $this->response);
        $pageService->execute();
        $this->render($pageService);

    }

    public function removeAction()
    {
        $pageService = new RemoveRulePageService($this->request, $this->response);
        $pageService->execute();
        $this->render($pageService);
    }
}
