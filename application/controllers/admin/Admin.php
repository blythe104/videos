<?php
if (!defined('BASEPATH')) {exit('No direct script access allowed');}
class Admin extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/adminmodel');
	}

    /**
     * @author lindsey
     * 管理员页面信息展示
     * createTime 2016.8.20
     */
	public function index()
	{
		$lists  = $this->adminmodel->getCommonAdmin();
		$this->load->view('admin/Admin.html',array("list"=>$lists));
	}

    /**
     * @author lindsey
     * 添加管理员页面
     * createTime 2016.8.20
     */
	public function addAdmin()
	{
		echo "haha";
	}
}
