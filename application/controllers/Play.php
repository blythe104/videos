<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class play extends CI_Controller {

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
        $params['title'] = "play";
        $this->load->view($page,$params);	
	}
    public function index()
    {
        $id  = $_GET['id'];
        $condition = array(
            'vcontent.id' => $id,
            'is_del' => 0
        );
        $lists  = $this->contentmodel->getcontents($condition);
        $this->view('play.html',array('contentlists'=>$lists));
    }
    


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */