<?php 
class Members extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/membermodel');
	}

	public function index()
	{
		$lists  = $this->membermodel->getCommonMember();
		$this->load->view('admin/Members.html',array("list"=>$lists));
	}

	public function addMember()
	{
		echo "haha";
	}
}
