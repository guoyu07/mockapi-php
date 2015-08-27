<?php
class ObjectUtil
{
    /**
     * @param object|array $src 原始对象或数组
     * @param object $target 目标对象
     */
    static function copyProperties($src, &$target){
        foreach($src as $k => $v){
            $target->$k = $v;
        }
    }
}