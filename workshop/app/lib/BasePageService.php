<?php

/**
 * Class BasePageService
 */
abstract class BasePageService
{
    const PARAM_RULE_REQUIRED = 1;
    const PARAM_RULE_NUMBER = 2;
    const PARAM_RULE_POSITIVE_NUMBER = 3;
    const PARAM_RULE_NOT_NEGATIVE_NUMBER = 4;
    const PARAM_RULE_JSON = 5;
    const PARAM_RULE_OBJECT = 6;

    private $properties;
    /**
     * @var \Phalcon\Http\Request
     */
    private $request;
    /**
     * @var \Phalcon\Http\Response
     */
    private $response;

    /**
     * @var mixed
     */
    private $returnData;

    /**
     * @param \Phalcon\Http\Request $request
     * @param \Phalcon\Http\Response $response
     */
    function __construct($request, $response){
        $this->request = $request;
        $this->response = $response;
        $this->init();
    }

    protected function checkParam($paramName, $paramValue, $paramRule)
    {
        switch ($paramRule) {
            case self::PARAM_RULE_REQUIRED:
                if (null === $paramValue || '' === $paramValue) {
                    throw new MockApiException($paramName . ' is required', ErrorInfo::ERROR_NO_INVALID_PARAM);
                };
                break;
            case self::PARAM_RULE_NUMBER:
                if (null !== $paramValue && '' !== $paramValue && !is_numeric($paramValue)) {
                    throw new MockApiException($paramName . ' is not number', ErrorInfo::ERROR_NO_INVALID_PARAM);
                }
                $this->set($paramName, $paramValue + 0);
                break;
            case self::PARAM_RULE_POSITIVE_NUMBER:
                if (null !== $paramValue && '' !== $paramValue && (!is_numeric($paramValue) || $paramValue <= 0)) {
                    throw new MockApiException($paramName . ' is not a positive number', ErrorInfo::ERROR_NO_INVALID_PARAM);
                }
                $this->set($paramName, $paramValue + 0);
                break;
            case self::PARAM_RULE_NOT_NEGATIVE_NUMBER:
                if (null !== $paramValue && '' !== $paramValue && (!is_numeric($paramValue) || $paramValue < 0)) {
                    throw new MockApiException($paramName . ' is a negative number', ErrorInfo::ERROR_NO_INVALID_PARAM);
                }
                $this->set($paramName, $paramValue + 0);
                break;
            case self::PARAM_RULE_JSON:
                if (null !== $paramValue && '' !== $paramValue) {
                    $json = json_decode($paramValue, true);
                    if (JSON_ERROR_NONE != json_last_error()) {
                        throw new MockApiException($paramName . ' is not a valid json', ErrorInfo::ERROR_NO_INVALID_PARAM);
                    }
                    $this->set($paramName, $json);
                }
                break;
            case self::PARAM_RULE_OBJECT:
                if (null !== $paramValue && '' !== $paramValue) {
                    $object = json_decode($paramValue);
                    if (JSON_ERROR_NONE != json_last_error()) {
                        throw new MockApiException($paramName . ' is not a valid json', ErrorInfo::ERROR_NO_INVALID_PARAM);
                    }
                    $this->set($paramName, $object);
                }
                break;
        }
    }

    protected function checkParams(&$params, $rules)
    {
        if (!empty($rules) && is_array($rules)) {
            foreach($rules as $paramName => $paramRules){
                $paramValue = $params[$paramName];
                if (is_array($paramRules)) {
                    sort($paramRules);
                    foreach ($paramRules as $paramRule) {
                        $this->checkParam($paramName, $paramValue, $paramRule);
                    }
                } else {
                    $this->checkParam($paramName, $paramValue, $paramRules);
                }
            }
        }
    }

    function execute()
    {
        try{
            $this->properties = array_merge($this->request->get());
            $this->checkParams($this->properties, $this->getParamRules());
            $this->returnData = $this->doExecute();
        }catch (\Exception $e){
            $this->returnData = $this->error($e->getCode(), $e->getMessage());
        }
    }

    protected function get($name = null)
    {
        if (isset($name)) {
            return $this->properties[$name];
        } else {
            return $this->properties;
        }
    }

    protected function set($name, $value)
    {
        if (isset($name)) {
            $this->properties[$name] = $value;
        }
    }

    public function buildResponse($errorNo, $data, $errorMessage='')
    {
        $out = array(
            'error' => $errorNo,
        );
        if(isset($data)){
            $out['data'] = $data;
        }
        if(!empty($errorMessage)){
            $out['message'] = $errorMessage;
        }
        return $out;
    }

    public function success($data)
    {
        return $this->buildResponse(ErrorInfo::ERROR_NO_SUCCESS, $data);
    }

    public function error($errorNo, $errorMessage = '')
    {
        return $this->buildResponse($errorNo, null, $errorMessage);
    }

    abstract protected function doExecute();

    protected function init()
    {

    }

    protected function getParamRules()
    {
        return null;
    }

    /**
     * @return \Phalcon\Http\Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param \Phalcon\Http\Request $request
     */
    public function setRequest($request)
    {
        $this->request = $request;
    }

    /**
     * @return \Phalcon\Http\Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param \Phalcon\Http\Response $response
     */
    public function setResponse($response)
    {
        $this->response = $response;
    }

    /**
     * @return mixed
     */
    public function getReturnData()
    {
        return $this->returnData;
    }

    /**
     * @param mixed $returnData
     */
    public function setReturnData($returnData)
    {
        $this->returnData = $returnData;
    }
}