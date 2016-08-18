<?php
class VadvModel extends CI_Model{
	
	private static $table = "vadv";
	private static $primary_key = "id";
	
    public function __construct()
    {
        parent::__construct();
		
    }
	
	/**
	*获取大广告图信息
	*/
    public function get_adv($type = "default" )
    {
        return $this->db->select("adv_path")->from(Self::$table)->where('adv_type',1)->get()->result_array();
    }
}
?>
