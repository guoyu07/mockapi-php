<?php
/**
 * Class NotEmptyEvaluator
 */
class NotEmptyEvaluator extends EmptyEvaluator
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
        return '!EMPTY';
    }
}