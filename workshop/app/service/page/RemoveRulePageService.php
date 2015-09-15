<?php
/**
 * Class RemoveRulePageService
 */
class RemoveRulePageService extends JsonPageService
{
    protected function getParamRules()
    {
        return array(
            '_id' => self::PARAM_RULE_REQUIRED,
        );
    }

    protected function doExecute()
    {
        $rule = Rule::findById($this->get('_id'));
        if($rule){
            $ret = $rule->delete();
            if($ret){
                return $this->success($ret);
            }else{
                return $this->error(ErrorInfo::ERROR_NO_DB_OPERATION_ERROR, 'remove failed');
            }
        }else{
            return $this->error(ErrorInfo::ERROR_NO_DATA_NOT_FOUND, 'data not found');
        }
    }
}