<?php
/**
 * Class FindRulePageService
 */
class ModifyRulePageService extends JsonPageService
{

    function doExecute()
    {
        $rule = Rule::create($this->get('rule'));
        if($rule->group === ''){
            $rule->group = null;
        }
        $this->beforeSave($rule);
        $ret = $rule->save($rule);
        if ($ret) {
            return $this->success($ret);
        } else {
            return $this->error(ErrorInfo::ERROR_NO_DB_OPERATION_ERROR, 'modify failed');
        }
    }

    public function beforeSave($rule)
    {
        if (empty($rule->_id)) {
            throw new MockApiException('_id is not set', ErrorInfo::ERROR_NO_INVALID_PARAM);
        }
        if (empty($rule->url)) {
            throw new MockApiException('url is not set', ErrorInfo::ERROR_NO_INVALID_PARAM);
        }
        if (empty($rule->res)) {
            throw new MockApiException('res is not set', ErrorInfo::ERROR_NO_INVALID_PARAM);
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