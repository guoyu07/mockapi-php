<?php

/**
 * Class IndexPageService
 */
class IndexPageService extends BasePageService
{
    /**
     * @var string
     */
    private $url;

    protected function doExecute()
    {
        $rules = Rule::find(array(
            array(
                'url' => $this->url,
            )
        ));
        if ($rules) {
            $contextMap = array(
                RuleConditionExpressionOperand::CONTEXT_TYPE_REQUEST => $_REQUEST,
                RuleConditionExpressionOperand::CONTEXT_TYPE_GET => $_GET,
                RuleConditionExpressionOperand::CONTEXT_TYPE_POST => $_POST,
                RuleConditionExpressionOperand::CONTEXT_TYPE_HEADER => HttpUtils::getHttpHeaders(),
                RuleConditionExpressionOperand::CONTEXT_TYPE_COOKIE => $_COOKIE,
            );
            $matcher = new RuleResponseMatcher();
            foreach ($rules as $rule) {
                if ($matcher->match($rule, $contextMap)) {
                    if (is_array($rule->res) || is_object($rule->res)) {
                        $this->setReturnType(self::RETURN_TYPE_JSON);
                        return $this->success($rule->res);
                    } else {
                        return $rule->res;
                    }
                }
            }
        }
        $this->setReturnType(self::RETURN_TYPE_JSON);
        return $this->error(1, 'can\'t match any url for [' . $this->url . ']');
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }


}