<?php 
class memberModel extends CI_Model{
        public function __construct()
        {
                parent::__construct();
        }

        public function getmembers()
        {
                $result =  $this->db->select('*')->from('vadmin')->get()->result_array();
		$result =  empty($result) ? array() : $result;
		return $result;        
	}

}
 
?>

