<?php
/**
 * Class NotInEvaluator
 */
class NotInEvaluator extends InEvaluator
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
        return '!IN';
    }
}