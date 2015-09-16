<?php
/**
 * Class ContainEvaluator
 */
class ContainEvaluator implements IExpressionEvaluator
{

    /**
     * @param Expression $expression
     * @return mixed
     */
    public function evaluate($expression)
    {
        return strpos($expression->getLeft(), $expression->getRight()) !== false;
    }

    /**
     * @return string
     */
    public function getOperator()
    {
        return 'CONTAIN';
    }
}