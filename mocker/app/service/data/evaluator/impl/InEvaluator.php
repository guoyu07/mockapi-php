<?php
/**
 * Class InEvaluator
 */
class InEvaluator implements IExpressionEvaluator
{

    /**
     * @param Expression $expression
     * @return mixed
     */
    public function evaluate($expression)
    {
        $left = $expression->getLeft();
        $right = $expression->getRight();
        if(isset($left) && isset($right)){
            if(is_string($right)){
                $right = explode(',', $right);
            }else if(!is_array($right)){
                $right = array($right);
            }
            return in_array($left, $right);
        }else{
            return false;
        }
    }

    /**
     * @return string
     */
    public function getOperator()
    {
        return 'IN';
    }
}