<?php
/**
 * Class BaseModel ģ�ͻ���
 */
class BaseModel extends \Phalcon\Mvc\Collection
{
    /**
     * ���������͵�ʵ��������ָ������������ϸ�������
     * @param object|array $src ԭʼ���������
     * @return object
     */
    static function create($src){
        $class = new ReflectionClass(get_called_class());
        $target = $class->newInstance();
        ObjectUtil::copyProperties($src, $target);
        return $target;
    }
}