<?php 
class contentModel extends CI_Model{
    /**
     * 构造函数信息
     */
    public function __construct()
    {
            parent::__construct();
    }

    /**
     * 根据传递条件获取数据信息
     * @param array $condition
     * @param int $page
     * @param int $count
     * @param string $order
     * @return array
     */
    public function getcontents($condition = array(),$page = 1,$count = 16,$order = "sort")
    {
        if($condition)
        {
            $this->db->where($condition);
        }
        $result =  $this->db->select('vcontent.*,support_count,comment_count,views_count,repost_count,download_count')
            ->from('vcontent')
            ->join('vdetail','vdetail.vid = vcontent.id','left')
            ->limit($count,($page-1)*$count)
            ->order_by("$order desc")
            ->get()
            ->result_array();

        $result =  empty($result) ? array() : $result;
        return $result;
    }

    /**
     * 根据相应的条件获取内容总数
     * @param $condition
     * @return mixed
     */
    public function getContentsCount($condition)
    {
        if($condition)
        {
            $this->db->where($condition);
        }
        $result =  $this->db->select('*')
            ->from('vcontent')
            ->count_all_results();
        return $result;
    }

    /**
     * 添加数据信息
     * @param $data
     * @return mixed
     */
    public function add($data)
    {
        return	$this->db->insert('vcontent',$data);
    }

    /**
     * 编辑数据信息
     * @param $data
     * @return mixed
     */
    public function edit($data)
    {
        return $this->db->where('id',$data['id'])->update('vcontent',$data);
    }

}
 
?>

               
