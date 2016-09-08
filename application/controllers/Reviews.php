<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class reviews extends CI_Controller {

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
	
	public function View($page,$params = array())
	{
		$content['title'] = "reviews";
		$this->load->view('header.html',$content);
        $this->load->view($page,$params);	
	}
    public function index()
    {
        $page  = isset($_GET['page']) ? $_GET['page'] :1 ;
        $count = isset($_GET['row'])  ? $_GET['row']  :4 ;
        $filters['page']  = $page;
        $filters['rows']  = $count;
        $lists          =  $this->contentmodel->getVideos($page,$count);
        $rows           =  $this->contentmodel->getVideosCount();
        $pagination     =  getPagination($filters,$rows,strtolower(__class__));

        $condition['whereis'] = 2;
        $littleads  = $this->contentmodel->getcontents($condition,1,4);
		$this->view('reviews.html',array('contentlists'=>$lists,'littleads' => $littleads,'pagination' => $pagination));
    }



}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */