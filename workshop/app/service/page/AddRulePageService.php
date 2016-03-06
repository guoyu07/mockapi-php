<?php

/**
 * Class SaveRulePageService
 */
class AddRulePageService extends JsonPageService
{

    function doExecute()
    {
        $rule = Rule::create($this->get('rule'));
        if($rule->group === ''){
            $rule->group = null;
        }
        $this->beforeSave($rule);
        $ret = $rule->save();
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
        $condition = array('url' => $rule->url,);
        if($rule->group !== ''){
            $condition['group'] = $rule->group;
        }else{
            $condition['group'] = $rule->null;
        }
        $list = Rule::find(array(
            $condition,
        ));
        if (!empty($list)) {
            throw new MockApiException('rule has been existed'. ($rule->group ? ' in group [' . $rule->group . ']' : ''), ErrorInfo::ERROR_NO_INVALID_PARAM);
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