<?php

/**
 * Class RuleResponseMatcher
 */
class RuleResponseMatcher
{

    public function match($rule, $params, $headers)
    {
        $condition = null;
        if ($rule->conditions) {
            foreach ($rule->conditions as $rc) {
                if ($this->matchRuleCondition($rc, $params, $headers)) {
                    return $rc->res;
                }
            }
        }
        return $rule->res;
    }

    /**
     * @param RuleCondition $condition
     * @param array $params
     * @param array $headers
     * @return bool
     */
    private function matchRuleCondition($condition, $params, $headers)
    {
        if(is_array($condition->expressions)){
            foreach($condition->expressions as $exp){
                if($this->matchRuleConditionExpression($exp, $params, $headers)){
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
     * @param array $params
     * @param array $headers
     * @return bool
     */
    private function matchRuleConditionExpression($rce, $params, $headers){
        $context = null;
        if($rce->conditionType == RuleConditionExpression::CONDITION_TYPE_PARAM){
            $context = $params;
        }else if($rce->conditionType == RuleConditionExpression::CONDITION_TYPE_HEADER){
            $context = $headers;
        }else{
            throw new MockApiException("unsupported condition type '" . $rce->conditionType . '"', ErrorInfo::UNSUPPORTED_CONDITION_TYPE);
        }
        $engine = new RuleConditionExpressionEngine();
        return boolval($engine->evaluate($rce, $context));
    }
}