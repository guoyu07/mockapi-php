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
                'url'=> $this->url,
            )
        ));
        if($rules){
            foreach($rules as $rule){
                if(is_array($rule->res) || is_object($rule->res)){
                    $this->setReturnType(self::RETURN_TYPE_JSON);
                    echo json_encode($rule->res);
                }else{
                    echo $rule->res;
                }
            }
        }else{
            $this->setReturnType(self::RETURN_TYPE_JSON);
            return $this->error(1, 'can\'t match any url for [' . $this->url . ']');
        }
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