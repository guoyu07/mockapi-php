<?php
class ObjectUtil
{
    /**
     * @param object|array $src ԭʼ���������
     * @param object $target Ŀ�����
     */
    static function copyProperties($src, &$target){
        foreach($src as $k => $v){
            $target->$k = $v;
        }
    }
}