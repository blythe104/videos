<?php 
class memberModel extends CI_Model{
    public function __construct()
    {
            parent::__construct();
    }

    /**
     * 添加会员数据
     * @param $data
     * @return mixed
     */
    public function add($data)
    {
        return $this->db->insert('vmember',$data);
    }

    /**
     * 编辑会员信息
     * @param $data
     * @return mixed
     */
    public function edit($data)
    {
        return $this->db->where('mid',$data['mid'])->update('vmember',$data);
    }

    /**
     * 会员登录
     * @param $username
     * @param $password
     * @return array
     */
    public function Login($username,$password)
    {
        $condition = array(
            'select' => "mid",
            'where' => array(
                'musername' => $username,
                'mpassword' => $password,
                'mstatus'   => 1
            )
        );
        return $this->getMembers($condition);
    }

    /**
     * 根据条件返回会员信息
     * @return array
     */
    public function getMembers($condition)
    {
        $this->parseParameter($condition);
        $result =  $this->db->from('vmember')
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
            'select' => 'vmember.mid,vmember.musername,vmember.mmobile,vmember.mcreate_time,vmember.mstatus',
            'join'  => array(
                'table' => "vmemberinfo",
                'condition' => 'vmemberinfo.muid = vmember.mid',
                'direction' => "left"
            ),
            'limit' => array(
                'limit' => $count,
                'offset' => ($page -1)*$count
            ),
            'order' => 'vmember.mcreate_time desc'
        );
        return  $this->getMembers($condition);
    }

    /**
     * 根据相应的条件获取内容总数
     * @param $condition
     * @return mixed
     */
    public function getCommonMemberCount()
    {
        $result =  $this->db->select('*')
            ->from('vmember')
            ->count_all_results();
        return $result;
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
                $this->db->join($value['table'],$value['condition'],$value['direction']);
            }
        }
    }

}
 
?>

