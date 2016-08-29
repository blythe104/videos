<?php
if (!defined('BASEPATH')) {exit('No direct script access allowed');}
class Members extends CI_Controller{

    /**
     * 构造函数
     */
	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/membermodel');
	}

    /**
     * 会员首页数据显示
     */
	public function index()
	{
        $page  = isset($_GET['page']) ? $_GET['page'] :1 ;
        $count = isset($_GET['row'])  ? $_GET['row']  :8 ;
        $filters['page']  = $page;
        $filters['rows']  = $count;
        $lists          =  $this->membermodel->getCommonMember($page,$count);
        $rows           =  $this->membermodel->getCommonMemberCount();
        $pagination     =  getPagination($filters,$rows,strtolower(__class__));
		$this->load->view('admin/Members.html',array("list"=>$lists,'pagination' => $pagination));
	}

    /**
     * @author lindsey
     * 添加会员数据
     * createTime 2016.08.29
     */
	public function addMember()
	{
		echo "haha";
	}

    /**
     * @author lindsey
     * 编辑会员信息
     * createTime 2016.08.29
     */
    public function editMemberStatus()
    {
        $post = $_POST;
        $muid = $post['mid'];
        $status = $post['mstatus'];

        $data['mid'] = $muid;
        $data['mstatus'] = $status;

        if($this->membermodel->edit($data))
        {
            $data = array(
                'msg' => "编辑成功！",
                'content' => ""
            );
            ApiSuccess($data);
        }
    }
}
