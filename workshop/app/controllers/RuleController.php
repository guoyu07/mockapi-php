<?php

class RuleController extends BaseController
{

    public function indexAction()
    {
        echo 'hello';
    }

    public function findByIdAction()
    {
        $pageService = new FindRuleByIdPageService($this->request, $this->response);
        $pageService->execute();
        $this->render($pageService);
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

    public function saveRuleConditionAction()
    {
        $pageService = new SaveRuleConditionPageService($this->request, $this->response);
        $pageService->execute();
        $this->render($pageService);
    }

    public function removeRuleConditionAction()
    {
        $pageService = new RemoveRuleConditionPageService($this->request, $this->response);
        $pageService->execute();
        $this->render($pageService);
    }

    public function testAction(){
        $pageService = new TestRulePageService($this->request, $this->response);
        $pageService->execute();
        $this->render($pageService);
    }
}
