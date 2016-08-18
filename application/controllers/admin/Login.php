<?php 
class login extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->load->view('admin/admin.html');
	}
	
	
	/**
	* 登录
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
	
	public function Loginout()
	{
		$this->session->unset_userdata('username');
		header('Location:/');
	}
	/**
	*登录后的首页显示
	*/

	public function main()
	{

		$this->load->view('admin/main.html');
	}
	public function dashboard()
	{
		$this->load->view('admin/dashboard.html');
	}
	
	public function manageblog()
	{
		$this->load->view('admin/manageblog.html');
	}
	
	public function newpost()
	{
		$this->load->view('admin/newpost.html');
	}
	
	public function messages()
	{
		$this->load->view('admin/messages.html');
	}

	public function reports()
	{
		$this->load->view('admin/reports.html');
	}

	public function elements()
	{
		$this->load->view('admin/elements.html');
	
	}

	public function widgets()
	{
		$this->load->view('admin/widgets.html');
	
	}

	public function calendar()
	{
		$this->load->view('admin/calendar.html');
	
	}
	
	public function tables()
	{
		$this->load->view('admin/tables.html');
	}
}
