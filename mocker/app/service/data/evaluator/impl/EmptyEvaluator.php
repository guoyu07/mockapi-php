<?php
/**
 * Class EmptyEvaluator
 */
class EmptyEvaluator implements IExpressionEvaluator
{

    /**
     * @param Expression $expression
     * @return mixed
     */
    public function evaluate($expression)
    {
        return empty($expression->getLeft());
    }

    /**
     * @return string
     */
    public function getOperator()
    {
        return 'EMPTY';
    }
}