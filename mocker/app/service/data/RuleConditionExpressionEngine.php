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
     * @param array $contextMap
     * @return mixed
     */
    function evaluate($rce, $contextMap){
        $operator = strtoupper($rce->operator);
        $evaluator = $this->getEvaluator($operator);
        if(!$evaluator){
            throw new MockApiException("unsupported condition operator '" . $operator . '"', ErrorInfo::UNSUPPORTED_CONDITION_OPERATOR);
        }
        $exp = new Expression();
        $exp->setLeft($this->getOperandValue($rce->left, $contextMap));
        $exp->setRight($this->getOperandValue($rce->right, $contextMap));
        $exp->setOperator($operator);
        return $evaluator->evaluate($exp);
    }

    /**
     * @param RuleConditionExpressionOperand $operand
     * @param array $contextMap
     * @return null
     */
    private function getOperandValue($operand, $contextMap){
        if(isset($operand)){
            if($operand->isVariable){
                $context = $contextMap[$operand->contextType];
                if(!isset($context)){
                    throw new MockApiException('unsupported context type [' . $operand->contextType . ']', ErrorInfo::UNSUPPORTED_CONTEXT_TYPE);
                }
                return $context[$operand->value];
            }
            return $operand->value;
        }
        return null;
    }

    protected function initialize(){
        if(empty($this->evaluators)){
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