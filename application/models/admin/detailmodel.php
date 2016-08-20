<?php
class detailModel extends CI_Model{

    private $mainTable = "vdetail";
    private $slaveSupportTalbe = "vsupportlog";
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
    public function checkUserisSupport($uid)
    {
        $data  = $this->db->where('muid',$uid)->get($this->slaveSupportTalbe)->row_array();
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
}

?>

               
