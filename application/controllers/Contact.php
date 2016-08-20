<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class contact extends CI_Controller {

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
	}
	
	public function View($page,$params = array())
	{
		$content['title'] = "contact";
		$this->load->view('header.html',$content);
        $this->load->view($page,$params);
	}
	/**
	*联系我首页
	*/
	public function index()
    {
        $this->view('contact.html');
    }


}

/* End of file Home.php */
/* Location: ./application/controllers/welcome.php */
