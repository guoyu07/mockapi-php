<?php
/**
 * Class MockApiException
 */
class MockApiException extends RuntimeException
{
    function __construct($message=null, $error=null, $previousException=null){
        parent::__construct($message, $error, $previousException);
    }
}