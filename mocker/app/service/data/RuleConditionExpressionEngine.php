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
        $exp->setLeft($this->getOperandValue($rce->left));
        $exp->setRight($this->getOperandValue($rce->right));
        $exp->setOperator($operator);
        return $evaluator->evaluate($exp);
    }

    /**
     * @param RuleConditionExpressionOperand $operand
     * @param array $context
     * @return null
     */
    private function getOperandValue($operand, $context){
        if(isset($operand)){
            if($operand->isVariable){
                return $context[$operand->value];
            }
            return $operand->value;
        }
        return null;
    }

    protected function initialize(){
        if(empty(self::$evaluators)){
            $evaluators = array(
                new EqualEvaluator(),
                new NotEqualEvaluator(),
                new GraterEvaluator(),
                new GraterEqualEvaluator(),
                new LessEvaluator(),
                new LessEqualEvaluator(),
                new EmptyEvaluator(),
                new NotEmptyEvaluator(),
                new IssetEvaluator(),
                new IsNotSetEvaluator(),
                new InEvaluator(),
                new NotInEvaluator(),
                new ContainEvaluator(),
                new NotContainEvaluator(),
            );
            foreach($evaluators as $evaluator){
                $this->registerEvaluator($evaluator);
            }
        }
    }

    /**
     * @param IExpressionEvaluator $evaluator
     */
    public function registerEvaluator($evaluator){
        $this->evaluators[$evaluator->getOperator()] = $evaluator;
    }

    /**
     * @param string $operator
     * @return IExpressionEvaluator
     */
    public function getEvaluator($operator){
        return $this->evaluators[$operator];
    }
}