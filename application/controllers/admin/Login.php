<?php 
class login extends CI_Controller{
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
		$password = $post['password'];
		//导入usermodel
		$this->load->model('admin/usermodel');
		$result  = $this->usermodel->Login($username,$password);
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
		header('Location:/');
	}

    /**
     * @author lindsey
     * 登录后展示页面
     * createTime 2016.05.19
     */
	public function main()
	{
		$this->load->view('admin/main.html');
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
