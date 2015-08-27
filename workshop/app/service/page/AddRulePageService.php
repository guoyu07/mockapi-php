<?php

/**
 * Class SaveRulePageService
 */
class AddRulePageService extends JsonPageService
{

    function doExecute()
    {
        $rule = Rule::create($this->get('rule'));
        $this->beforeSave($rule);
        $ret = $rule->save($rule);
        if ($ret) {
            return $this->success($ret);
        } else {
            return $this->error(ErrorInfo::ERROR_NO_DB_OPERATION_ERROR, 'add failed');
        }
    }

    public function beforeSave($rule)
    {
        if (empty($rule->url)) {
            throw new MockApiException('url is not set', ErrorInfo::ERROR_NO_INVALID_PARAM);
        }
        if (empty($rule->res)) {
            throw new MockApiException('res is not set', ErrorInfo::ERROR_NO_INVALID_PARAM);
        }
        $list = Rule::find(array(
            array('url' => $rule->url)
        ));
        if (!empty($list)) {
            throw new MockApiException('rule has been existed', ErrorInfo::ERROR_NO_INVALID_PARAM);
        }
    }

    protected function getParamRules()
    {
        return array(
            'rule' => array(
                self::PARAM_RULE_REQUIRED,
                self::PARAM_RULE_OBJECT,
            ),
        );
    }


}