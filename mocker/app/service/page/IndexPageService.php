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
    /**
     * @var string
     */
    private $group;

    protected function doExecute()
    {
        $params = array(
            'url' => $this->url,
        );
        if ($this->group) {
            $params['group'] = $this->group;
        }
        $rules = Rule::find(array(
            $params,
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
                $res = $matcher->match($rule, $contextMap);
                if (isset($res)) {
                    if (is_array($res) || is_object($res)) {
                        $this->setReturnType(self::RETURN_TYPE_JSON);
                        return $this->success($rule->res);
                    } else {
                        return $res;
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

    /**
     * @return string
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param string $group
     */
    public function setGroup($group)
    {
        $this->group = $group;
    }

}