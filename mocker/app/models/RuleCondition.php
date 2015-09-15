<?php
/**
 * Class RuleCondition 规则条件模型
 */
class RuleCondition extends ObjectModel
{
    /**
     * 逻辑类型：与
     */
    const LOGIC_TYPE_AND = 'AND';
    /**
     * 逻辑类型：或
     */
    const LOGIC_TYPE_OR = 'OR';

    /**
     * @var string
     */
    public $condId;
    /**
     * @var string
     */
    public $logicType;
    /**
     * @var array
     */
    public $expressions;
    /**
     * @var string
     */
    public $res;

}