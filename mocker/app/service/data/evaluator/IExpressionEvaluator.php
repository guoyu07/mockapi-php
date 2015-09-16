<?php
/**
 * Interface IExpressionEvaluator
 */
interface IExpressionEvaluator
{
    /**
     * @param Expression $expression
     * @return mixed
     */
    public function evaluate($expression);

    /**
     * @return string
     */
    public function getOperator();
}