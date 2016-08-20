<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class home extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('admin/contentmodel');
    }

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
	public function View($page,$params = array())
	{
		$content['title'] = "home";
		$this->load->view('header.html',$content);
        $this->load->view($page,$params);	
	}

    /**
     * 首页数据信息
     * @author lindsey
     * createTime 2016.08.20
     */
	public function index()
	{
        //获取小广告信息
        $content['littleads'] = $this->contentmodel->getLittle();
        //获取大广告
        $content['bigads'] = $this->contentmodel->getBig();
		$this->view('home.html',$content);
	}

    /**
     * 会员登录
     * @author lindsey
     * createTime 2016.08.20
     */
    public function Login()
    {
        $post = $_POST;
        $username = $post['username'];
        $password = md5($post['password']);
        //导入usermodel
        $this->load->model('admin/membermodel');
        $result  = $this->membermodel->Login($username,$password);
        if(!empty($result))
        {
            $member['musername'] = $username;
            $member['mid']       = $result[0]['mid'];
            $this->session->set_userdata('member',$member);
            $data['status']  = 1;
            $data['msg']     = "登录成功！";
            $data['url']     = "/";
            json_return($data);
        }else{
            $data['status']  = 0;
            $data['msg']     = "登录失败！";
            $data['url']     = "/";
            json_return($data);
        }
    }

    /**
     * @author lindsey
     * 退出登录
     * createTime 2016.08.20
     */
    public function LoginOut()
    {
        $this->session->unset_userdata('musername');
        $data['status']  = 1;
        $data['msg']     = "退出成功！";
        $data['url']     = "/";
        json_return($data);
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
