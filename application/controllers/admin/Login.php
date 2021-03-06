<?php  if (!defined('BASEPATH')) {exit('No direct script access allowed');}
class login extends CI_Controller{

    /**
     * 构造函数
     */
	public function __construct()
	{
		parent::__construct();
	}

    /**
     * @author lindsey
     * 登录页面信息
     * createTime 2016.05.19
     */
	public function index()
	{
		$this->load->view('admin/Login.html');
	}

    /**
     * @author lindsey
     * 登录
     * createTime 2016.05.19
     */
	public function Login()
	{
		$post = $_POST;
		$username = $post['username'];
		$password = md5($post['password']);
		//导入usermodel
		$this->load->model('admin/adminmodel');
		$result  = $this->adminmodel->Login($username,$password);
		if(!empty($result))
		{
			$this->session->set_userdata('username',$username);
			$data['status']  = 1;
			$data['msg']     = "登录成功！";
			$data['url']     = "Login/main";
			json_return($data);
		}else{
			$data['status']  = 0;
			$data['msg']     = "登录失败！";
			$data['url']     = "Login";
			json_return($data);
		}
	}

    /**
     * @author lindsey
     * 退出登录
     * createTime 2016.05.19
     */
	public function Loginout()
	{
		$this->session->unset_userdata('username');
        echo "<script>window.location.href='/admin/login';</script>";
	}

    /**
     * @author lindsey
     * 登录后展示页面
     * createTime 2016.05.19
     */
	public function main()
	{
        if($this->session->userdata('username'))
        {
            $this->load->view('admin/Main.html');
        }else{
            echo "<script>window.location.href='/admin/login';</script>";
        }

	}

    /**
     * @author lindsey
     * 系统首页
     * createTime 2016.05.19
     */
	public function dashboard()
	{
		$this->load->view('admin/dashboard.html');
	}
}
