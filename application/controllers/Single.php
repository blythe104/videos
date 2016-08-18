<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Single extends CI_Controller {

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
    }

    /**
     * 视图页面
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
     * 获取单个视频详细信息
     * @author lindsey
     */
    public function index()
    {
        $id     =   $_GET['id'];
        $condition = array(
            'vcontent.id' => $id,
            'is_del' => 0
        );
        $content  = $this->contentmodel->getcontents($condition);
        $this->view('single.html',array('content' => $content));
    }


}