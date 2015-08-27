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

}
