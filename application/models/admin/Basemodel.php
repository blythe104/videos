<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Base_model
 */
class Basemodel extends CI_Model {

    public $keyField;
    public $filters;

    /**
     * 获取搜索参数
     * @author wangke
     * @param	array $default       默认值
     * @param	array $withAddInfo   是否附件信息
     * @return	array $filters       搜索条件
     */
    public function getFilters($default = array('rows'=>12), $withAddInfo = true) {
        $filters = getQueryString();
        if ($withAddInfo) {
            $default_rows = 9;
            // 默认值
            $filters['order'] = !empty($filters['order']) ? $filters['order'] : (!empty($default['order']) ? $default['order'] : $this->keyField);
            $filters['dir']   = !empty($filters['dir']) ? $filters['dir'] : (!empty($default['dir']) ? $default['dir'] : 'desc');
            $filters['rows']  = isset($filters['rows']) && intval($filters['rows']) > 0 ? intval($filters['rows']) : (intval($default['rows']) > 0 ? intval($default['rows']) : $default_rows);
            $page = isset($filters['page']) ? intval($filters['page']) : 0;
            if ($page < 1) {
                $page            = 1;
                $filters['page'] = 1;
            }
            $filters['index']  = ($page - 1) * $filters['rows'];
        }
        $this->filters = $filters;
        return $filters;
    }

}
