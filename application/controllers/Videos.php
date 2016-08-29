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
        $page  = isset($_GET['page']) ? $_GET['page'] :1 ;
        $count = isset($_GET['row'])  ? $_GET['row']  :8 ;
        $filters['page']  = $page;
        $filters['rows']  = $count;
        $lists          =  $this->contentmodel->getCommon($page,$count);
        $rows           =  $this->contentmodel->getCommonCount();
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

    /**
     * 点赞数据信息
     * @author lindsey
     * createTime 2016.08.23
     */
    public function supportCount()
    {
        $post  = $_POST;
        $id    = isset($post['id']) ? $post['id'] : 0 ;
        $uid   = isset($post['uid']) ? $post['uid'] : 0;

        $ip =  real_ip();
        //检测用户是否已经点赞
        if(!$this->checkIsSupport($uid,$ip,$id))
        {
            //查看数据信息是否已经在内容详情表中存在
            $result = $this->detailmodel->checkishas($id);
            if($result)
            {
                //如果存在那么将它的点赞数加一
                $download = $result['support_count'];
                $data['vid'] = $id;
                $data['support_count'] = $download +1;
                if($this->detailmodel->edit($data) && $this->updateSupportLog($uid,$ip,$id))
                {
                    $data   = array(
                        'msg' => '',
                        'content' => array()
                    );
                    ApiSuccess($data);
                }else{
                    ApiSuccess('点赞失败！');
                }
            }else{
                //如果不存在那么添加数据
                $data['vid'] = $id;
                $data['support_count'] = 1;
                if($this->detailmodel->add($data) && $this->updateSupportLog($uid,$ip,$id))
                {
                    $data   = array(
                        'msg' => '',
                        'content' => array()
                    );
                    ApiSuccess($data);
                }else{
                    ApiSuccess('点赞失败！');
                }
            }
        }else{
            ApiSuccess('您已经点过赞了！');
        }
    }

    /**
     * 检测用户是否已经点赞
     * @param $uid
     * @param $ip
     * @param $vid
     * @return bool
     */
    private function checkIsSupport($uid,$ip,$vid)
    {
        $userResult = $this->detailmodel->checkUserisSupport($uid,0,$vid);
        $ipResult   = $this->detailmodel->checkUserisSupport(0,$ip,$vid);
        if($userResult || $ipResult)
        {
            return true;
        }else{
            return false;
        }
    }

    /**
     *
     * @param int $whois
     * @param int $ip
     * @param int $vid
     * @return bool
     */
    private function updateSupportLog($whois = 0,$ip = 0,$vid = 0)
    {
        $logdata['muid'] = empty($whois) ? 0 : $whois;
        $logdata['mip']  = empty($ip)    ? 0 : $ip;
        $logdata['vid']  = $vid;
        $logdata['create_time'] = time();
        if($this->detailmodel->addSupportLog($logdata))
        {
            return true;
        }else{
            return false;
        }
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
