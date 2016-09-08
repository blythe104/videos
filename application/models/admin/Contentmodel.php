<?php 
class contentModel extends CI_Model{

    //小广告数据
    const LITTLE_ADS   = 1;
    //大广告数据
    const BIG_ADS      = 2;
    //普通数据
    const COMMON_MUSIC = 3;
    //普通数据
    const COMMON_VIDEO = 4;

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
    public function getcontents($condition,$page = 1,$count = 16,$in_condition = array())
    {
        $mulitCondition  = array(
            'select' => 'vcontent.*,support_count,comment_count,
                         views_count,repost_count,download_count',
            'where'    => $condition,
            'where_in' => $in_condition,
            'join'  => array(
                'table' => 'vdetail',
                'condition' => 'vdetail.vid = vcontent.id',
                'direction' => 'left'
            ),
            'limit'  => array(
                'limit' => $count,
                'offset' =>($page-1)*$count
            ),
            'order' => "sort desc",
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
    public function getLittle($page,$count)
    {
        $condition = array('is_del' => 0, 'whereis' => self::LITTLE_ADS);
        return  $this->getcontents($condition,$page,$count);
    }

    /**
     * 获取大广告数据
     * @return array
     */
    public function getBig($page,$count)
    {
        $condition = array('is_del' => 0, 'whereis' => self::BIG_ADS);
        return  $this->getcontents($condition,$page,$count);
    }

    /**
     * 获取音乐数据
     * @return array
     */
    public function getMusic($page,$count)
    {
        $condition = array('is_del' => 0, 'whereis' => self::COMMON_MUSIC);
        return  $this->getcontents($condition,$page,$count);
    }

    /**
     * 获取视频数据
     * @return array
     */
    public function getVideos($page,$count)
    {
        $condition = array('is_del' => 0, 'whereis' => self::COMMON_VIDEO);
        return  $this->getcontents($condition,$page,$count);
    }

    /**
     * 获取音乐和视频的内容
     * @return array
     */
    public function getContentsMV($page,$pagecount)
    {
        $condition = array('is_del' => 0);
        $in_condition = array('field' => 'whereis','value' => array(3,4));
        return $this->getcontents($condition,$page,$pagecount,$in_condition);
    }

    /**
     * 获取大小广告数据
     * @param $page
     * @param $pagecount
     * @return array
     */
    public function getContentBL($page,$pagecount)
    {
        $condition    = array('is_del' => 0);
        $in_condition = array('field' => 'whereis','value' => array(1,2));
        return $this->getcontents($condition,$page,$pagecount,$in_condition);
    }

    /**
     * 根据相应的条件获取内容总数
     * @param $condition
     * @return mixed
     */
    public function getContentsCount($condition,$in_condition = array())
    {
        $Newcondition['where']    = $condition;
        $Newcondition['where_in'] = $in_condition;
        $this->parseParameter($Newcondition);
        $result =  $this->db->select('*')
            ->from('vcontent')
            ->count_all_results();
        return $result;
    }

    /**
     * 获取小广告总数据
     * @return array
     */
    public function getLittleCount()
    {
        $condition = array('is_del' => 0, 'whereis' => self::LITTLE_ADS);
        return  $this->getContentsCount($condition);
    }

    /**
     * 获取大广告总数据
     * @return array
     */
    public function getBigCount()
    {
        $condition = array('is_del' => 0, 'whereis' => self::BIG_ADS);
        return  $this->getContentsCount($condition);
    }

    /**
     * 根据相应的条件获取音乐内容总数
     * @param $condition
     * @return mixed
     */
    public function getMusicCount()
    {
        $condition = array('is_del' => 0, 'whereis' => self::COMMON_MUSIC);
        return $this->getContentsCount($condition);
    }

    /**
     * 根据相应的条件获取电影内容总数
     * @param $condition
     * @return mixed
     */
    public function getVideosCount()
    {
        $condition = array('is_del' => 0, 'whereis' => self::COMMON_VIDEO);
        return $this->getContentsCount($condition);
    }

    /**
     * 获取音乐和视频的总数
     * @return mixed
     */
    public function getMVCount()
    {
        $condition = array('is_del' => 0);
        $in_condition = array('field' => 'whereis','value' => array(3,4));
        return $this->getContentsCount($condition,$in_condition);
    }

    /**
     * 获取大小广告的总数
     * @return mixed
     */
    public function getBLCount()
    {
        $condition = array('is_del' => 0);
        $in_condition = array('field' => 'whereis','value' => array(1,2));
        return $this->getContentsCount($condition,$in_condition);
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
            if($key == "where_in")
            {
                if(!empty($value))
                {
                    $this->db->where_in($value['field'],$value['value']);
                }
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

               
