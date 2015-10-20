<?php

/**
 * Class RuleResponseMatcher
 */
class RuleResponseMatcher
{

    public function match($rule, $contextMap)
    {
        $condition = null;
        if ($rule->conditions) {
            foreach ($rule->conditions as $rc) {
                if ($this->matchRuleCondition($rc, $contextMap)) {
                    return $rc->res;
                }
            }
        }
        return $rule->res;
    }

    /**
     * @param RuleCondition $condition
     * @param array $contextMap
     * @return bool
     */
    private function matchRuleCondition($condition, $contextMap)
    {
        if(is_array($condition->expressions)){
            foreach($condition->expressions as $exp){
                if($this->matchRuleConditionExpression($exp, $contextMap)){
                    if ($condition->logicType == RuleCondition::LOGIC_TYPE_OR) {
                        return true;
                    }
                }else{
                    if ($condition->logicType == RuleCondition::LOGIC_TYPE_AND) {
                        return false;
                    }
                }

            }
            return true;
        }
        return false;
    }

    /**
     * @param RuleConditionExpression $rce
     * @param array $contextMap
     * @return bool
     */
    private function matchRuleConditionExpression($rce, $contextMap){
        $engine = new RuleConditionExpressionEngine();
        return boolval($engine->evaluate($rce, $contextMap));
    }
}