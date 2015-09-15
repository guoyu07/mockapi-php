<?php
/**
 * Class JsonPageService
 */
abstract class JsonPageService extends BasePageService
{
    public function getReturnType(){
        return self::RETURN_TYPE_JSON;
    }
}