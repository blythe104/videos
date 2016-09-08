<?php
if (!defined('BASEPATH')) {exit('No direct script access allowed');}
class Content extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
        $this->config->load('multiconfig');
		$this->load->model('admin/contentmodel');
	}

    /**
     * 获取视频列表页数据信息
     */
	public function index()
	{
        $page  = isset($_GET['page']) ? $_GET['page'] :1 ;
        $count = isset($_GET['row'])  ? $_GET['row']  :8 ;
        $filters['page']  = $page;
        $filters['rows']  = $count;
        $lists          =  $this->contentmodel->getContentsMV($page,$count);
        $rows           =  $this->contentmodel->getMVCount();
        $pagination     =  getPagination($filters,$rows,strtolower(__class__));
		$this->load->view('admin/Content.html',array('contentlists'=>$lists,'pagination' => $pagination));

	}

    /**
     * 添加视频数据信息
     */
	public function AddContent()
	{
		$post = $_POST;
		if(!empty($post))
		{
			foreach($post as $key => $value)
            {
                $data[$key] = $value;
            }
			$data['create_time'] = time();
			$this->contentmodel->add($data);
            $data = array(
                'msg' => "添加成功！",
                'content' => array()
            );
            ApiSuccess($data);
		}

        $AppropriateAge = $this->config->item('age-appropriate');
        $VideosLevel    = $this->config->item('videos-level');
        $Whereis        = $this->config->item('whereisvideos');

        $data      = array(
                            'AppropriateAge' => $AppropriateAge,
                            'VideosLevel' => $VideosLevel,
                            'Whereis'     => $Whereis
                        );

		$this->load->view('admin/AddContent.html',$data);
	}

    /**
     * 编辑视频内容信息
     */
	public function EditContent()
	{
        $id  = isset($_GET['id']) ? $_GET['id'] : 0;
        if(!empty($_POST))
        {
            foreach($_POST as $key => $value)
            {
                $data[$key] = $value;
            }
            $this->contentmodel->edit($data);
            $data = array(
                'msg' => "编辑成功！",
                'content' => array()
            );
            ApiSuccess($data);
        }
        $condition = array(
            'vcontent.id' => $id,
            'is_del' => 0
        );
        $content  = $this->contentmodel->getcontents($condition);

        $AppropriateAge = $this->config->item('age-appropriate');
        $VideosLevel    = $this->config->item('videos-level');
        $Whereis        = $this->config->item('whereisvideos');

        $data      = array(
            'AppropriateAge' => $AppropriateAge,
            'VideosLevel' => $VideosLevel,
            'Whereis'     => $Whereis,
            'content'     => $content
        );

        $this->load->view('admin/EditContent.html',$data);
	}

    /**
     * 删除视频信息
     */
    public function DelContent()
    {
        $id  = isset($_GET['id']) ? $_GET['id'] : 0;
        $data  = array(
            'id' => $id,
            'is_del' => 1
        );
        if($this->contentmodel->edit($data))
        {
            $result = array(
                'msg' => '编辑成功！',
                'content' => array()
            );
            ApiSuccess($result);
        }
    }

    /**
     * 回收箱内容信息
     */
    public function trashContent()
    {
        $condition = array(
            'is_del' => 1
        );
        $page  = isset($_GET['page']) ? $_GET['page'] :1 ;
        $count = isset($_GET['row'])  ? $_GET['row']  :8 ;
        $filters['page']  = $page;
        $filters['rows']  = $count;
        $lists          =  $this->contentmodel->getcontents($condition,$page,$count);
        $rows           =  $this->contentmodel->getContentsCount($condition);
        $pagination     =  getPagination($filters,$rows,strtolower(__class__));
        $this->load->view('admin/trashContent.html',array('contentlists'=>$lists,'pagination' => $pagination));
    }

    /**
     * 广告列表
     */
    public function AdvList()
    {
        $page  = isset($_GET['page']) ? $_GET['page'] :1 ;
        $count = isset($_GET['row'])  ? $_GET['row']  :8 ;
        $filters['page']  = $page;
        $filters['rows']  = $count;
        $lists          =  $this->contentmodel->getContentBL($page,$count);
        $rows           =  $this->contentmodel->getBLCount();
        $pagination     =  getPagination($filters,$rows,strtolower(__FUNCTION__));
        $this->load->view('admin/AdvContent.html',array('contentlists'=>$lists,'pagination' => $pagination));
    }

    /**
     * 添加广告信息
     */
    public function AddAdv()
    {
        $post = $_POST;
        if(!empty($post))
        {
            foreach($post as $key => $value)
            {
                $data[$key] = $value;
            }
            $data['create_time'] = time();
            $this->contentmodel->add($data);
            $data = array(
                'msg' => "添加成功！",
                'content' => array()
            );
            ApiSuccess($data);
        }
        $Whereis        = $this->config->item('whereisadv');
        $data      = array(
            'Whereis'     => $Whereis,
        );
        $this->load->view('admin/AddAdv.html',$data);
    }

    /**
     * 编辑广告信息
     */
    public function EditAdv()
    {
        $id  = isset($_GET['id']) ? $_GET['id'] : 0;
        if(!empty($_POST))
        {
            foreach($_POST as $key => $value)
            {
                $data[$key] = $value;
            }
            $this->contentmodel->edit($data);
            $data = array(
                'msg' => "编辑成功！",
                'content' => array()
            );
            ApiSuccess($data);
        }
        $condition = array(
            'vcontent.id' => $id,
            'is_del' => 0
        );
        $content  = $this->contentmodel->getcontents($condition);

        $Whereis        = $this->config->item('whereisadv');

        $data      = array(
            'Whereis'     => $Whereis,
            'content'     => $content
        );

        $this->load->view('admin/EditAdv.html',$data);
    }
}
