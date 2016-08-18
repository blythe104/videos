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
   
	public function index()
	{
        $condition = array(
            'is_hot' => 1,
            'is_del' => 0,
            'whereis' => 2
        );
        $content['littleads'] = $this->contentmodel->getcontents($condition);

        $condition['whereis'] = 3;
        $content['bigads'] = $this->contentmodel->getcontents($condition);
		$this->view('home.html',$content);

	}





}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
