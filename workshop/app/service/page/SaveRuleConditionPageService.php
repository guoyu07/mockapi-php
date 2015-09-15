<?php
/**
 * Class SaveRuleConditionPageService
 */
class SaveRuleConditionPageService extends JsonPageService
{
    protected function getParamRules()
    {
        return array(
            '_id' => array(
                self::PARAM_RULE_REQUIRED,
            ),
            'ruleCondition' => array(
                self::PARAM_RULE_REQUIRED,
                self::PARAM_RULE_OBJECT,
            ),
        );
    }


    protected function doExecute()
    {
        $id = $this->get('_id');
        $rule = Rule::findById($id);
        if($rule){
            $ruleCondition = RuleCondition::create($this->get('ruleCondition'));
            $exists = false;
            if($ruleCondition->condId){
                if(is_array($rule->conditions)){
                    foreach($rule->conditions as $key => $rc){
                        if($rc->condId == $ruleCondition->condId){
                            $exists = true;
                            $rule->conditions[$key] = $ruleCondition;
                            break;
                        }
                    }
                }
            }else{
                $ruleCondition->condId = ObjectUtil::guid();
            }

            if(!$exists){
                $rule->conditions[] = $ruleCondition;
            }
            $ret = $rule->save();
            if($ret){
                return $this->success($ret);
            }else{
                return $this->error(ErrorInfo::ERROR_NO_DB_OPERATION_ERROR, 'add ruleCondition failed');
            }
        }else{
            return $this->error(ErrorInfo::ERROR_NO_DATA_NOT_FOUND, 'rule not found for _id=' . $id);
        }
    }
}