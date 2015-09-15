<?php
/**
 * Class RuleConditionExpressionEngine
 */
class RuleConditionExpressionEngine
{
    /**
     * @var array
     */
    private $evaluators = array();

    public function __construct(){
        $this->initialize();
    }

    /**
     * @param RuleConditionExpression $rce
     * @param array $context
     * @return mixed
     */
    function evaluate($rce, $context){
        $operator = strtoupper($rce->operator);
        $evaluator = $this->getEvaluator($operator);
        if(!$evaluator){
            throw new MockApiException("unsupported condition operator '" . $operator . '"', ErrorInfo::UNSUPPORTED_CONDITION_OPERATOR);
        }
        $exp = new Expression();
        $exp->setLeft($context[$rce->key]);
        $exp->setRight($rce->value);
        $exp->setOperator($operator);
        return $evaluator->evaluate($exp);
    }

    protected function initialize(){

    }

    public function registerEvaluator($operator, $evaluator){
        $this->evaluators[$operator] = $evaluator;
    }

    /**
     * @param string $operator
     * @return IExpressionEvaluator
     */
    public function getEvaluator($operator){
        return $this->evaluators[$operator];
    }
}