<?php
/**
 * Class NotEqualEvaluator
 */
class NotEqualEvaluator extends EqualEvaluator
{

    public function evaluate($expression)
    {
        return !parent::evaluate($expression);
    }

    public function getOperator()
    {
        return '!=';
    }
}