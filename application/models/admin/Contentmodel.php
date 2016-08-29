<?php 
class contentModel extends CI_Model{

    //普通数据
    const COMMON_VIDEO = 1;
    //小广告数据
    const LITTLE_ADS   = 2;
    //大广告数据
    const BIG_ADS      = 3;

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
        $mulitCondition  = array(
            'select' => 'vcontent.*,support_count,comment_count,
                         views_count,repost_count,download_count',
            'where' => $condition,
            'join'  => array(
                'table' => 'vdetail',
                'condition' => 'vdetail.vid = vcontent.id',
                'direction' => 'left'
            ),
            'limit'  => array(
                'limit' => $count,
                'offset' =>($page-1)*$count
            ),
            'order' => "$order desc",
        );

        $this->parseParameter($mulitCondition);
        $result =  $this->db->get('vcontent')->result_array();
        $result =  empty($result) ? array() : $result;
        return $result;
    }

    /**
     * 获取单个数据信息
     * @param $vid
     * @return array
     */
    public function getSingleContent($vid)
    {
        $condition = array('vcontent.id' => $vid, 'is_del' => 0);
        return  $this->getcontents($condition);
    }

    /**
     * 获取小广告数据
     * @return array
     */
    public function getLittle()
    {
        $condition = array('is_hot' => 1, 'is_del' => 0, 'whereis' => self::LITTLE_ADS);
        return  $this->getcontents($condition);
    }

    /**
     * 获取小广告数据
     * @return array
     */
    public function getBig()
    {
        $condition = array('is_hot' => 1, 'is_del' => 0, 'whereis' => self::BIG_ADS);
        return  $this->getcontents($condition);
    }

    /**
     * 获取小广告数据
     * @return array
     */
    public function getCommon($page,$pagecount)
    {
        $condition = array('is_hot' => 0, 'is_del' => 0, 'whereis' => self::COMMON_VIDEO);
        return  $this->getcontents($condition,$page,$pagecount);
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
     * 获取小广告数据
     * @return array
     */
    public function getLittleCount()
    {
        $condition = array('is_hot' => 1, 'is_del' => 0, 'whereis' => self::LITTLE_ADS);
        return  $this->getContentsCount($condition);
    }

    /**
     * 获取小广告数据
     * @return array
     */
    public function getBigCount()
    {
        $condition = array('is_hot' => 1, 'is_del' => 0, 'whereis' => self::BIG_ADS);
        return  $this->getContentsCount($condition);
    }

    /**
     * 获取小广告数据
     * @return array
     */
    public function getCommonCount()
    {
        $condition = array('is_hot' => 0, 'is_del' => 0, 'whereis' => self::COMMON_VIDEO);
        return  $this->getContentsCount($condition);
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

               
