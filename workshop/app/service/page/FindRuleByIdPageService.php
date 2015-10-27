<?php
/**
 * Class FindRuleByIdPageService
 */
class FindRuleByIdPageService extends JsonPageService
{

    protected function doExecute()
    {
        return $this->success(Rule::findById($this->get('_id')));
    }

    protected function getParamRules()
    {
        return array(
            '_id' => self::PARAM_RULE_REQUIRED,
        );
    }


}