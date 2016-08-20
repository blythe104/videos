<?php
class adminModel extends CI_Model{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 管理员登录
     * @param $username
     * @param $password
     * @return array
     */
    public function Login($username,$password)
    {
        $condition = array(
            'select' => "id",
            'where' => array(
                'username' => $username,
                'password' => $password,
                'status'   => 1
            )
        );
        return $this->getAdmin($condition);
    }

    /**
     * 根据条件获取管理员信息
     * @param $condition
     * @return array
     */
    public function getAdmin($condition)
    {
        $this->parseParameter($condition);
        $result =  $this->db->from('vadmin')
                        ->get()
                        ->result_array();
        $result =  empty($result) ? array() : $result;
        return $result;
    }

    /**
     * 获取普通条件下的管理员数据
     * @param $page
     * @param $count
     * @return array
     */
    public function getCommonAdmin($page = 1,$count = 15)
    {
        $condition =  array(
            'select' => 'id,username,mobile,create_time',
            'where' => array(
                'status' => 1
            ),
            'limit' => array(
                'limit' => $count,
                'offset' => ($page -1)*$count
            ),
            'order' => 'create_time desc'
        );
        return $this->getAdmin($condition);
    }

    /**
     * 初始化参数信息
     * @param $condition
     */
    public function parseParameter($condition)
    {
        foreach($condition as $key => $value)
        {
            if($key == "select")
            {
                $this->db->select($value);
            }
            if($key == "where")
            {
                $this->db->where($value);
            }
            if($key == "order")
            {
                $this->db->order_by($value);
            }
            if($key == "limit")
            {
                $this->db->limit($value['limit'],$value['offset']);
            }
            if($key == 'join')
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

