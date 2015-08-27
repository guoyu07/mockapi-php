<?php

/**
 * Class ListRulePageService
 */
class ListRulePageService extends JsonPageService
{
    const MIN_PAGE_SIZE = 1;
    const MAX_PAGE_SIZE = 100;

    protected function doExecute()
    {
        $params = array();
        foreach ($this->get() as $key => $val) {
            if (in_array($key, array('url', 'id', 'tag', 'group', 'page', 'pageSize'))) {
                $params[$key] = $val;
            }
        };
        if (!empty($params['id'])) {
            return $this->success(Rule::findById($params['id']));
        } else {
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
                unset($params['page']);
                $page += 0;
                if ($page <= 0) {
                    $page = 1;
                }
                $queryParams = array(
                    $params,
                    'sort' => array(
                        'url' => 1,
                    ),
                    'limit' => $pageSize,
                    'skip' => $pageSize * $page,
                );
            }else{
                $queryParams = array(
                    $params,
                    'sort' => array(
                        'url' => 1,
                    ),
                );
            }
            return $this->success(array(
                'count' => Rule::count(array(
                    $params
                )),
                'list' => Rule::find($queryParams),
            ));
        }
    }

}