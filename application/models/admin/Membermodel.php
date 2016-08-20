<?php 
class memberModel extends CI_Model{
    public function __construct()
    {
            parent::__construct();
    }

    /**
     * 根据条件返回会员信息
     * @return array
     */
    public function getmembers($condition)
    {
        $this->parseParameter($condition);
        $result =  $this->db->select('*')
                        ->from('vmember')
                        ->get()
                        ->result_array();
        $result =  empty($result) ? array() : $result;
        return $result;
    }


    /**
     * 获取会员信息
     * @param int $page
     * @param int $count
     * @return array
     */
    public function getCommonMember($page = 1,$count = 15)
    {
        $condition =  array(
            'where' => array(
                'mstatus' => 1
            ),
            'limit' => array(
                'limit' => $count,
                'offset' => ($page -1)*$count
            ),
            'order' => 'mcreate_time desc'
        );
        return  $this->getmembers($condition);
    }


    /**
     * 初始化参数信息
     * @param $condition
     */
    public function parseParameter($condition)
    {
        foreach($condition as $key => $value)
        {
            if($key == "where")
            {
                $this->db->where($value);
            }else if($key == "order")
            {
                $this->db->order_by($value);
            }else if($key == "limit")
            {
                $this->db->limit($value['limit'],$value['offset']);
            }else if($key == 'join')
            {
                if(count($value) > 1)
                {
                    foreach($value as $k => $v)
                    {
                        $this->db->join($v['table'],$v['condition'],$v['direction']);
                    }
                }else{
                    $this->db->join($value['table'],$value['condition'],$value['direction']);
                }

            }
        }
    }

}
 
?>

