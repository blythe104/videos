<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Single extends CI_Controller {

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
        $this->load->model('admin/detailmodel');
    }

    /**
     * @author lindsey
     * 视图页面
     * @param $page
     * @param array $params
     */
    public function View($page,$params = array())
    {
        $content['title'] = "videos";
        $this->load->view('header.html',$content);
        $this->load->view($page,$params);
    }

    /**
     * 获取单个视频详细信息
     * @author lindsey
     */
    public function index()
    {
        $id     =   $_GET['id'];
        $content  = $this->contentmodel->getSingleContent($id);
        $comment  = $this->detailmodel->getComment($id);
        $commentCount  = $this->detailmodel->getCommentCount($id);
        $comment  = list_to_tree($comment);
        //p($comment);
        $this->view('single.html',array('content' => $content,'comment' => $comment,'commentCount' => $commentCount));
    }

    /**
     * @author lindsey
     * 用户对视频或者图书做评价
     */
    public function sendComment()
    {
        $post  = $_POST;
        $uid   = isset($post['uid']) ? $post['uid'] : 0;
        $content = $post['content'];
        $vid     = $post['vid'];
        $pcommentId  = $post['commentId'];

        $data['muid'] = $uid;
        $data['pid']  = $pcommentId;
        $data['content'] = $content;
        $data['vid']     = $vid;
        $data['create_time'] = time();
        if($this->detailmodel->addComment($data))
        {
            $data = array(
                'msg' => "评论成功！",
                'content' => $content
            );
            ApiSuccess($data);
        }
    }

}