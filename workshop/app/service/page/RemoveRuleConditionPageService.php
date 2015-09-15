<?php
/**
 * Class RemoveRuleConditionPageService
 */
class RemoveRuleConditionPageService extends JsonPageService
{
    protected function getParamRules()
    {
        return array(
            '_id' => array(
                self::PARAM_RULE_REQUIRED,
            ),
            'condId' => array(
                self::PARAM_RULE_REQUIRED,
            ),
        );
    }


    protected function doExecute()
    {
        $id = $this->get('_id');
        $condId = $this->get('condId');
        $rule = Rule::findById($id);
        if($rule){
            //var_dump($rule);
            $exists = false;
            if(is_array($rule->conditions)){
                foreach($rule->conditions as $idx => $rc){
                    if($rc->condId == $condId){
                        $exists = true;
                        array_splice($rule->conditions, $idx, 1);
                        break;
                    }
                }
            }

            if($exists){
                $ret = $rule->save();
                if($ret){
                    return $this->success($ret);
                }else{
                    return $this->error(ErrorInfo::ERROR_NO_DB_OPERATION_ERROR, 'add ruleCondition failed');
                }
            }else{
                return $this->error(ErrorInfo::ERROR_NO_DATA_NOT_FOUND, 'ruleCondition not found for _id=' . $id .' and condId=' . $condId);
            }
        }else{
            return $this->error(ErrorInfo::ERROR_NO_DATA_NOT_FOUND, 'rule not found for _id=' . $id);
        }
    }
}