<?php

/**
 * Class ListRulePageService
 */
class ListRulePageService extends JsonPageService
{
    const MIN_PAGE_SIZE = 1;
    const MAX_PAGE_SIZE = 100;
    const DEFAULT_PAGE_SIZE = 10;

    protected function doExecute()
    {
        $params = array();
        foreach ($this->get() as $key => $val) {
            if (!empty($val) && in_array($key, array('url', '_id', 'tag', 'group', 'page', 'pageSize'))) {
                $params[$key] = $val;
            }
        };
        if (!empty($params['_id'])) {
            $id = new MongoId($params['_id']);
            $params['_id'] = (object)$id;
        }
        $pageSize = $params['pageSize'];
        $page = $params['page'];
        if (isset($pageSize)) {
            unset($params['pageSize']);
            $page += 0;
            if ($pageSize < self::MIN_PAGE_SIZE) {
                $pageSize = 1;
            } else if ($pageSize > self::MAX_PAGE_SIZE) {
                $pageSize = self::MAX_PAGE_SIZE;
            }
        }
        if (isset($page)) {
            if(!isset($pageSize)){
                $pageSize = self::DEFAULT_PAGE_SIZE;
            }
            unset($params['page']);
            $page += 0;
            if ($page <= 0) {
                $page = 1;
            }
            $queryParams = array(
                'conditions' => $params,
                'sort' => array(
                    'url' => 1,
                ),
                'limit' => $pageSize,
                'skip' => $pageSize * ($page - 1),
            );
        } else {
            $queryParams = array(
                'conditions' => $params,
                'sort' => array(
                    'url' => 1,
                ),
            );
        }
        $result = array(
            'count' => Rule::count(array(
                'conditions' => $params
            )),
            'list' => Rule::find($queryParams),
        );
        if (isset($page)) {
            $result['page'] = $page;
            $result['pageSize'] = $pageSize;
            if($result['count'] > 0){
                $result['totalPage'] = ceil($result['count'] / $pageSize);
            }else{
                $result['totalPage'] = 0;
            }

        }
        return $this->success($result);
    }

}