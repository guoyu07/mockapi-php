<?php

/**
 * Class RuleConditionExpression 规则条件表达式模型
 */
class RuleConditionExpression extends ObjectModel
{
    const OPERATOR_EQUAL = '==';
    const OPERATOR_NOT_EQUAL = '!=';
    const OPERATOR_GRATER = '>';
    const OPERATOR_GRATER_EQUAL = '>=';
    const OPERATOR_LESS = '<';
    const OPERATOR_LESS_EQUAL = '<=';
    const OPERATOR_EMPTY = 'EMPTY';
    const OPERATOR_NOT_EMPTY = '!EMPTY';
    const OPERATOR_IS_SET = 'ISSET';
    const OPERATOR_IS_NOT_SET = '!ISSET';
    const OPERATOR_IN = 'IN';
    const OPERATOR_NOT_IN = '!IN';
    const OPERATOR_CONTAIN = 'CONTAIN';
    const OPERATOR_NOT_CONTAIN = '!CONTAIN';

    /**
     * @var RuleConditionExpressionOperand
     */
    public $left;
    /**
     * @var RuleConditionExpressionOperand
     */
    public $right;
    /**
     * @var string
     */
    public $operator;

}