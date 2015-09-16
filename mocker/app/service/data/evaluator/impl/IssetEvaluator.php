<?php
/**
 * Class IssetEvaluator
 */
class IssetEvaluator implements IExpressionEvaluator
{

    /**
     * @param Expression $expression
     * @return mixed
     */
    public function evaluate($expression)
    {
        $left = $expression->getLeft();
        return isset($left);
    }

    /**
     * @return string
     */
    public function getOperator()
    {
        return 'ISSET';
    }
}