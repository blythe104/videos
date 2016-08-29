<?php
    /**
     * 返回json数据信息
     * @author lindsey
     *  时间：2016.08.09
     */
    if(!function_exists('json_return')) {
        function json_return($data = array(), $header = true)
        {
            if ($header) {
                header('content-type:application/json;charset=utf8');

                exit(json_encode($data));
            }
        }
    }

    /**
     * 返回json格式(统一格式)
     * @author  lindsey
     * 时间：2016.08.23
     */
    if(!function_exists('ApiSuccess'))
    {
        function ApiSuccess($data)
        {
            $content = array(
                'status' => 1,
                'msg'    => $data['msg'],
                'content' => $data['content']
            );
            json_return($content);
        }
    }

    /**
     * 创建月份目录
     *
     * @param   string $path 在哪个目录下创建
     * @return    string   $new_path    新地址
     * @author  lindsey
     *  时间：2016.08.09
     */
    if (!function_exists('MakeMonthDir')) {
        function MakeMonthDir($path)
        {
            $month = date('Ym', time());
            $dir = preg_replace("/\/+$/", '', trim($path)) . '/' . $month;
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }
            return $month;
        }
    }


    /**
     *  截取字符串
     *  @author  lindsey
     *  时间：2016.08.10
     */
    if (!function_exists('CnTruncate')) {
        function CnTruncate($string, $length = 80, $etc = '...', $break_words = false, $middle = false, $encoding = 'utf-8')
        {
            if ($length == 0)
                return '';

            if (!function_exists('mb_strlen')) {
                function mb_strlen($str, $encoding = 'utf-8')
                {
                    return function_exists('iconv_strlen') ? iconv_strlen($str, $encoding) : strlen($str);
                }

                ;
                function mb_substr($str, $start, $length = null, $encoding = 'utf-8')
                {
                    return function_exists('iconv_substr') ? iconv_substr($str, $start, $length, $encoding) : substr($str, $start, $length);
                }

                ;
            }
            if (mb_strlen($string, $encoding) > $length) {
                $length -= min($length, mb_strlen($etc, $encoding));
                if (!$break_words && !$middle) {
                    $string = preg_replace('/\s+?(\S+)?$/', '', mb_substr($string, 0, $length + 1, $encoding));
                }
                if (!$middle) {
                    return mb_substr($string, 0, $length, $encoding) . $etc;
                } else {
                    return mb_substr($string, 0, $length / 2, $encoding) . $etc . mb_substr($string, -$length / 2, $encoding);
                }
            } else {
                return $string;
            }
        }
    }



    /**
     * 获取分页
     *
     * @param   array   $filters        参数, 包含页码，行数等信息
     * @param   int     $total          总记录数
     * @param   int     $action_page    操作页面
     * @param   boolean $get_info_only  是否只获取分页信息
     * @param   boolean $always_show    是否一直显示
     * @return	string  $code           html代码
     *
     */
    if(!function_exists('getPagination')) {

        function getPagination($filters = array(), $total = 0, $action_page = '', $get_info_only = false, $always_show = true)
        {

            // 如果总数为零
            $total_str = "总计 " . number_format($total) . " 条记录";
            if (empty($total)) {
                if ($get_info_only) {
                    return array();
                } else {
                    return "<div style='text-align:right'>{$total_str}</div>";
                }
            }

            // 计算分页信息
            $page = empty($filters['page']) ? 1 : $filters['page'];
            $rows = empty($filters['rows']) ? 12 : $filters['rows'];
            $filters['page_part'] = ceil($page/5);
            $total_pages = ceil($total / $rows);
            if ($total_pages < 1) {
                $total_pages = 1;
            }
            $previous_page = $page < 2 ? '' : $page - 1;
            $next_page = $page < $total_pages ? $page + 1 : '';
            $first_page = 1;
            $last_page = $total_pages;
            $page_limit = isset($filters['page_limit']) && intval($filters['page_limit']) > 0 ? intval($filters['page_limit']) : 5;
            $page_part  = isset($filters['page_part']) && intval($filters['page_part']) > 0 ? intval($filters['page_part']) : 1;
            $page_start = $page_limit * ($page_part - 1);
            $page_end   = $page_limit * $page_part;
            if ($page_end > $total_pages) {
                $page_end = $total_pages;
            }

            if ($get_info_only) {
                // 如果仅仅获取分页信息
                $page_info = array(
                    'total' => $total,
                    'total_pages' => $total_pages,
                    'page' => $page,
                    'rows' => $rows,
                    'previous_page' => $previous_page,
                    'next_page' => $next_page,
                    'first_page' => $first_page,
                    'last_page' => $last_page,
                    'action_page' => $action_page

                );
                return $page_info;
            } else {
                // 获取分页代码
                $filters['page_part'] = $page_part;
                $filters['page_limit'] = $page_limit;
                $filters['page'] = '';
                $query_str = getFilterString($filters);

                $page_numbers = "";
                for ($n = $page_start; $n < $page_end; $n++) {
                    $url = join('&', $filters);
                    $p   = $n + 1;
                    $class = $p == $page ? "class='current'" : "";
                    $page_numbers .= "<li><a href=\"$action_page?page={$p}{$query_str}\" {$class}>{$p}</a></li>\n";
                }

                $page_previous_part = "";
                if ($page_part > 1) {
                    $pp = $page_part - 1;
                    $filters['page_part'] = $pp;
                    $query_str = getFilterString($filters);
                    $s_page = 1;
                    $e_page = $page_limit * $pp;
                    $to_page = $page_start;
                    $l_str = $s_page == $e_page ? $s_page : $s_page . '...' . $e_page;
                    $page_previous_part = "<li><a class='p' href=\"$action_page?page={$to_page}{$query_str}\">{$l_str}</a></li>";
                }

                $page_next_part = "";
                if ($page_end < $total_pages) {
                    $pp = $page_part + 1;
                    $filters['page_part'] = $pp;
                    $query_str = getFilterString($filters);
                    $s_page = $page_limit * ($pp - 1) + 1;
                    $e_page = $total_pages;
                    $to_page = $page_end + 1;
                    $l_str = $s_page == $e_page ? $s_page : $s_page . '...' . $e_page;
                    $page_next_part = "<li><a class='p' href=\"$action_page?page={$to_page}{$query_str}\">{$l_str}</a></li>";
                }

                $p_first    = $page > 1 ? "<li class='first'><a  href=\"$action_page?page={$first_page}{$query_str}\">首页</a></li>" : "<li class='first'><a  class='disable'>首页</a></li>";
                $p_previous = $page > 1 ? "<li  class='previous'><a  href=\"$action_page?page={$previous_page}{$query_str}\" >上一页</a></li>" : "<li class='previous'><a  class='disable'>上一页</a></li>";
                $p_next = $page < $total_pages ? "<li class='next'><a class='p' href=\"$action_page?page={$next_page}{$query_str}\" >下一页</a></li>" : "<li class='next'><a  class='disable'>下一页</a></li>";
                $p_last = $page < $total_pages ? "<li class='last'><a class='p-last p' href=\"$action_page?page={$last_page}{$query_str}\" >尾页</a></li>" : "<li class='last'><a  class='disable'>尾页</a></li>";
                /*$page_info = "，每页显示 <input type='text' class='set-rows' value='{$rows}' onchange=\"Navigation.setPage(this, 'rows')\" title='修改每页显示条数' /> 条记录";*/

                $page_options = "";
                for ($n = 0; $n < $total_pages; $n++) {
                    $p = $n + 1;
                    $selected = $p == $page ? 'selected="selected"' : '';
                    $page_options .= "<option {$selected}>{$p}</option>\n";
                }
                $page_jump = "跳转到：<select class='page_jump' onchange=\"Navigation.setPage(this, 'page')\">{$page_options}</select>";

                $code = "
                <table border='0' cellspacing='0' cellpadding='0' class='pagination' align='right'>
                  <tr>

                    <td>
                      {$p_first}
                      {$p_previous}
                      {$page_previous_part}
                      {$page_numbers}
                      {$page_next_part}
                      {$p_next}
                      {$p_last}
                    </td>
                  </tr>
                </table>
                ";

                // 只有一页时不显示分页
                if (!$always_show && (int)$total < ((int)$rows + 1)) {
                    $code = '';
                }

                if (preg_match("/type=ok/i", $code)) {
                    $code = str_replace("type=ok", "", $code);
                }
                return $code;
            }
        }
    }


    /**
     * 获取参数字符串
     *
     * @param   array   $filters      参数, 包含页码，行数等信息
     * @return	string  $query_str     参数字符串
     */
    if(!function_exists('getFilterString'))
    {
        function getFilterString($filters = array())
        {
            $query_str = '';
            foreach ($filters as $key => $value) {
                if ($value != '') {
                    $query_str .= "&{$key}={$value}";
                }
            }
            return $query_str;
        }
    }

    // 获取$_GET信息
    if(!function_exists('getQueryString'))
    {
        function getQueryString() {
            $data = $_GET;
            if (!empty($data['user_type'])) {
                unset($data['user_type']);
            }
            return $data;
        }
    }

    /**
     * 获取搜索参数
     * @author wangke
     * @param	array $default       默认值
     * @param	array $withAddInfo   是否附件信息
     * @return	array $filters       搜索条件
     */
    if(!function_exists('getFilters'))
    {
        function getFilters($default = array('rows'=>12), $withAddInfo = true) {
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


    /**
     * 获取用户的IP地址
     * @author lindsey
     * createTime 2016.08.23
     */
    if(!function_exists('real_ip'))
    {
        function real_ip()
        {
            static $realip = NULL;

            if ($realip !== NULL)
            {
                return $realip;
            }

            if (isset($_SERVER))
            {
                if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
                {
                    $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);

                    /* 取X-Forwarded-For中第一个非unknown的有效IP字符串 */
                    foreach ($arr AS $ip)
                    {
                        $ip = trim($ip);

                        if ($ip != 'unknown')
                        {
                            $realip = $ip;

                            break;
                        }
                    }
                }
                elseif (isset($_SERVER['HTTP_CLIENT_IP']))
                {
                    $realip = $_SERVER['HTTP_CLIENT_IP'];
                }
                else
                {
                    if (isset($_SERVER['REMOTE_ADDR']))
                    {
                        $realip = $_SERVER['REMOTE_ADDR'];
                    }
                    else
                    {
                        $realip = '0.0.0.0';
                    }
                }
            }
            else
            {
                if (getenv('HTTP_X_FORWARDED_FOR'))
                {
                    $realip = getenv('HTTP_X_FORWARDED_FOR');
                }
                elseif (getenv('HTTP_CLIENT_IP'))
                {
                    $realip = getenv('HTTP_CLIENT_IP');
                }
                else
                {
                    $realip = getenv('REMOTE_ADDR');
                }
            }

            preg_match("/[\d\.]{7,15}/", $realip, $onlineip);
            $realip = !empty($onlineip[0]) ? $onlineip[0] : '0.0.0.0';

            return $realip;
        }
    }

    /**
     * 把返回的数据集转换成Tree
     * @param array $list 要转换的数据集
     * @param string $pid parent标记字段
     * @param string $level level标记字段
     * @return array
     * @author 麦当苗儿 <zuojiazi@vip.qq.com>
     */
    function list_to_tree($list, $pk = 'id', $pid = 'pid', $child = '_child', $root = 0)
    {
        // 创建Tree
        $tree = array();
        if (is_array($list)) {
            // 创建基于主键的数组引用
            $refer = array();
            foreach ($list as $key => $data) {
                $refer[$data[$pk]] =& $list[$key];
            }
            foreach ($list as $key => $data) {
                // 判断是否存在parent
                $parentId = $data[$pid];
                if ($root == $parentId) {
                    $tree[] =& $list[$key];
                } else {
                    if (isset($refer[$parentId])) {
                        $parent =& $refer[$parentId];
                        $parent[$child][] =& $list[$key];
                    }
                }
            }
        }
        return $tree;
    }

    /**
     * 辅助函数
     * @author  lindsey
     * 时间：2016.08.09
     */
    if(!function_exists('p'))
    {
        function p($value)
        {
            echo "<pre>";
            print_r($value);
            exit;
        }
    }




