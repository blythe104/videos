<?php 
class userModel extends CI_Model{
        public function __construct()
        {
                parent::__construct();
        }

        public function Login($username,$password)
        {
                $condition = array(
                        'username' => $username,
                        'password' => $password,
			'status'   => 1
                );
                $result =  $this->db->select('id')->from('vadmin')->where($condition)->get()->result_array();
		$result =  empty($result) ? array() : $result;
		return $result;        
	}

}
 
?>

