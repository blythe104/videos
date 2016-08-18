<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Videos extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
	public function __construct()
	{
		parent::__construct();
        $this->load->model('admin/contentmodel');
        $this->load->model('admin/detailmodel');
        $this->load->model('admin/Basemodel');
	}

    /**
     * 添加公用的头部信息数据
     * @param $page
     * @param array $params
     */
	public function View($page,$params = array())
	{
		$content['title'] = "videos";
		$this->load->view('header.html',$content);
        $this->load->view($page,$params);	
	}

    /**
     * 视频列表页数据
     */
    public function index()
    {
        $condition = array(
            'is_hot' => 0,
            'is_del' => 0,
            'whereis' => 1
        );
        $page  = isset($_GET['page']) ? $_GET['page'] :1 ;
        $count = isset($_GET['row'])  ? $_GET['row']  :8 ;
        $filters['page']  = $page;
        $filters['rows']  = $count;
        $lists          =  $this->contentmodel->getcontents($condition,$page,$count);
        $rows           =  $this->contentmodel->getContentsCount($condition);
        $pagination     =  getPagination($filters,$rows,strtolower(__class__));
		$this->view('videos.html',array('contentlists'=>$lists,'pagination' => $pagination));
    }


    /**
     *下载次数记录
     */
    public function downloadVideo()
    {
        $post  = $_POST;
        $id    = $post['id'];
        $result = $this->detailmodel->checkishas($id);
        if($result)
        {
            $download = $result['download_count'];
            $data['vid'] = $id;
            $data['download_count'] = $download +1;
            if($this->detailmodel->edit($data))
            {
                $data   = array(
                    'msg' => '',
                    'content' => array()
                );
                ApiSuccess($data);
            }
        }else{
            $data['vid'] = $id;
            $data['download_count'] = 1;
            if($this->detailmodel->add($data))
            {
                $data   = array(
                    'msg' => '',
                    'content' => array()
                );
                ApiSuccess($data);
            }
        }
    }


    public function supportCount()
    {
        $post  = $_POST;
        $id    = $post['id'];
        $result = $this->detailmodel->checkishas($id);
        if($result)
        {
            $download = $result['support_count'];
            $data['vid'] = $id;
            $data['support_count'] = $download +1;
            if($this->detailmodel->edit($data))
            {
                $data   = array(
                    'msg' => '',
                    'content' => array()
                );
                ApiSuccess($data);
            }
        }else{
            $data['vid'] = $id;
            $data['support_count'] = 1;
            if($this->detailmodel->add($data))
            {
                $data   = array(
                    'msg' => '',
                    'content' => array()
                );
                ApiSuccess($data);
            }
        }
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
