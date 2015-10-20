<?php
/**
 * Class Rule 规则模型
 */
class Rule extends BaseModel
{
    public $_id;
    /**
     * @var string
     */
    public $url;
    /**
     * @var
     */
    public $conditions;
    /**
     * @var array
     */
    public $groups;
    /**
     * @var array
     */
    public $res;
    /**
     * @var string
     */
    public $tag;

    protected static function _getResultset($params, Phalcon\Mvc\CollectionInterface $collection, $connection, $unique) {
        $resultSet = parent::_getResultset($params, $collection, $connection, $unique);
        if(!empty($resultSet)){
            if(is_array($resultSet)){
                foreach($resultSet as &$result){
                    self::covertToFullObject($result);
                }
            }else if(is_object($resultSet)){
                self::covertToFullObject($resultSet);
            }
        }
        return $resultSet;
    }

    /**
     * 将Rule转成完全的对象形式
     * @param $rule
     */
    public static function covertToFullObject(&$rule){
        $id= array();
        ObjectUtil::copyProperties($rule->_id, $id);
        $rule->_id = $id['$id'];
        if(is_array($rule->conditions)){
            foreach($rule->conditions as $idx => $rc){
                $ruleCondition = RuleCondition::create($rc);
                if(is_array($ruleCondition->expressions)){
                    foreach($ruleCondition->expressions as $idxExp => $exp){
                        $rce = RuleConditionExpression::create($exp);
                        if(is_array($rce->left)){
                            $rce->left = RuleConditionExpressionOperand::create($rce->left);
                        }
                        if(is_array($rce->right)){
                            $rce->right = RuleConditionExpressionOperand::create($rce->right);
                        }
                        $ruleCondition->expressions[$idxExp] =$rce;
                    }
                }
                $rule->conditions[$idx] = $ruleCondition;
            }
        }
    }
}
