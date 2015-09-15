<?php
/**
 * Class TestRulePageService
 */
class TestRulePageService extends JsonPageService
{

    protected function doExecute()
    {
        return $this->saveRule();
    }

    private function saveRule(){
        $data = array(
            'url' => '/add',
            'res' => array(
                'errno' => '0',
                'data' => array(
                    'name' => 'hehe',
                ),
            ),
        );
        $rc1 = new RuleCondition();
        $rc1->condId = ObjectUtil::guid();
        $rc1->logicType = RuleCondition::LOGIC_TYPE_AND;

        $rce1 = new RuleConditionExpression();
        $rce1->conditionType = RuleConditionExpression::CONDITION_TYPE_PARAM;
        $rce1->key = 'name';
        $rce1->value = 'Lily';
        $rce1->operator = RuleConditionExpression::OPERATOR_EQUAL;

        $rce2 = new RuleConditionExpression();
        $rce2->conditionType = RuleConditionExpression::CONDITION_TYPE_PARAM;
        $rce2->key = 'age';
        $rce2->value = 10;
        $rce2->operator = RuleConditionExpression::OPERATOR_GRATER;

        $rc1->expressions = array(
            $rce1,
            $rce2,
        );


        $rc2 = new RuleCondition();
        $rc2->condId = ObjectUtil::guid();
        $rc2->logicType = RuleCondition::LOGIC_TYPE_OR;

        $rce3 = new RuleConditionExpression();
        $rce3->conditionType = RuleConditionExpression::CONDITION_TYPE_HEADER;
        $rce3->key = 'WITH_XML_HTTP_REQUEST';
        $rce3->operator = RuleConditionExpression::OPERATOR_IS_SET;

        $rce4 = new RuleConditionExpression();
        $rce4->conditionType = RuleConditionExpression::CONDITION_TYPE_PARAM;
        $rce4->key = 'agent';
        $rce4->value = "MSIE";
        $rce4->operator = RuleConditionExpression::OPERATOR_NOT_CONTAIN;

        $rc2->expressions = array(
            $rce3,
            $rce4,
        );

        $data['conditions'] = array(
            $rc1,
            $rc2,
        );

        $rule = Rule::create($data);
//        return $this->success($rule);
        $ret = $rule->save();
        if($ret){
            return $this->success($ret);
        }else{
            return $this->error(ErrorInfo::ERROR_NO_DB_OPERATION_ERROR, 'save failed');
        }
    }
}