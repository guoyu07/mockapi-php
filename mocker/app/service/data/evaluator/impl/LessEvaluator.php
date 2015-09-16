<?php
/**
 * Class LessEvaluator
 */
class LessEvaluator implements IExpressionEvaluator
{

    /**
     * @param Expression $expression
     * @return mixed
     */
    public function evaluate($expression)
    {
        return $expression->getLeft() < $expression->getRight();
    }

    /**
     * @return string
     */
    public function getOperator()
    {
        return '<';
    }
}