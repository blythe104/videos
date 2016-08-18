<?php
class detailModel extends CI_Model{
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
        return	$this->db->insert('vdetail',$data);
    }

    /**
     * 编辑数据信息
     * @param $data
     * @return mixed
     */
    public function edit($data)
    {
        return $this->db->where('vid',$data['vid'])->update('vdetail',$data);
    }

    /**
     * 检测是否存在此id的信息
     * @param $id
     * @return int
     */
    public function checkishas($id)
    {
        $data  = $this->db->where('vid',$id)->get('vdetail')->row_array();
        return empty($data) ? 0 : $data;
    }
}

?>

               
