<?php
/**
 * Class IsNotSetEvaluator
 */
class IsNotSetEvaluator extends IssetEvaluator
{

    /**
     * @param Expression $expression
     * @return mixed
     */
    public function evaluate($expression)
    {
        return !parent::evaluate($expression);
    }

    /**
     * @return string
     */
    public function getOperator()
    {
        return 'ISSET';
    }
}