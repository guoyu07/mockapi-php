<?php
/**
 * Class BaseModel 模型基类
 */
class BaseModel extends \Phalcon\Mvc\Collection
{
    /**
     * 创建该类型的实例，并从指定对象或数组上复制属性
     * @param object|array $src 原始对象或数组
     * @return object
     */
    static function create($src){
        $class = new ReflectionClass(get_called_class());
        $target = $class->newInstance();
        ObjectUtil::copyProperties($src, $target);
        return $target;
    }
}