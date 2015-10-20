<?php

/**
 * Class ErrorInfo
 */
class ErrorInfo
{
    /**
     * 错误码：成功
     */
    const ERROR_NO_SUCCESS = 0;
    /**
     * 错误码：参数无效
     */
    const ERROR_NO_INVALID_PARAM = 1000;
    /**
     * 错误码：数据库操作失败
     */
    const ERROR_NO_DB_OPERATION_ERROR = 1001;
    /**
     * 错误码：数据不存在
     */
    const ERROR_NO_DATA_NOT_FOUND = 1002;
    /**
     * 错误码：不支持的上下文类型
     */
    const UNSUPPORTED_CONTEXT_TYPE = 2001;

    /**
     * 错误码：不支持的条件操作符
     */
    const UNSUPPORTED_CONDITION_OPERATOR = 2002;
}