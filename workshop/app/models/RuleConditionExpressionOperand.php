<?php
/**
 * Class RuleConditionExpressionOperand
 */
class RuleConditionExpressionOperand extends ObjectModel
{
    const CONTEXT_TYPE_REQUEST = 'request';
    const CONTEXT_TYPE_GET = 'get';
    const CONTEXT_TYPE_POST = 'post';
    const CONTEXT_TYPE_HEADER = 'header';
    const CONTEXT_TYPE_COOKIE = 'cookie';

    /**
     * @var string
     */
    public $contextType;
    /**
     * @var bool
     */
    public $isVariable;

    /**
     * @var string
     */
    public $value;
}