<?php
/**
 * Class NotContainEvaluator
 */
class NotContainEvaluator extends ContainEvaluator
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
        return '!CONTAIN';
    }
}