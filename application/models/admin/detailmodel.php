<?php
class detailModel extends CI_Model{

    private $mainTable = "vdetail";
    private $slaveSupportTalbe = "vsupportlog";
    private $slaveCommentTable = "vcomment";
    /**
     * 构造函数信息
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 添加数据信息
     * @param $data
     * @return mixed
     */
    public function add($data)
    {
        return	$this->db->insert($this->mainTable,$data);
    }

    /**
     * 编辑数据信息
     * @param $data
     * @return mixed
     */
    public function edit($data)
    {
        return $this->db->where('vid',$data['vid'])->update($this->mainTable,$data);
    }

    /**
     * 检测是否存在此id的信息
     * @param $id
     * @return int
     */
    public function checkishas($id)
    {
        $data  = $this->db->where('vid',$id)->get($this->mainTable)->row_array();
        return empty($data) ? 0 : $data;
    }

    /**
     * 检测用户是否已经点赞
     * @param $uid
     * @return int
     */
    public function checkUserisSupport($uid,$ip,$vid)
    {
        $condition  = array('vid'  => $vid);
        if($uid)
        {
            $condition['muid'] = $uid;
        }else{
            $condition['mip']  = $ip;
        }
        $data  = $this->db->where($condition)->get($this->slaveSupportTalbe)->row_array();
        return empty($data) ? 0 : $data;
    }

    /**
     * 添加点赞日志信息
     * @param $data
     * @return mixed
     */
    public function addSupportLog($data)
    {
        return $this->db->insert($this->slaveSupportTalbe,$data);
    }

    /**
     * 添加评论信息数据
     * @param $data
     * @return mixed
     */
    public function addComment($data)
    {
        return $this->db->insert($this->slaveCommentTable,$data);
    }

    /**
     * 获取单个内容的评论数据
     * @param $vid
     * @return array
     */
    public function getComment($vid)
    {
        $condition  = array('vid'  => $vid,'status' => 1);
        $order      = "create_time asc";
        $result     = $this->db->where($condition)->order_by($order)->get($this->slaveCommentTable)->result_array();
        return    empty($result) ? array() : $result;
    }

    /**
     * 获取评论总数
     * @param $vid
     * @return array
     */
    public function getCommentCount($vid)
    {
        $condition  = array('vid'  => $vid,'status' => 1);
        $result     = $this->db->from($this->slaveCommentTable)->where($condition)->count_all_results();
        return    $result;
    }
}

?>

               
