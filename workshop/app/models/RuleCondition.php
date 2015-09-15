<?php
/**
 * Class RuleCondition ��������ģ��
 */
class RuleCondition extends ObjectModel
{
    /**
     * �߼����ͣ���
     */
    const LOGIC_TYPE_AND = 'AND';
    /**
     * �߼����ͣ���
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