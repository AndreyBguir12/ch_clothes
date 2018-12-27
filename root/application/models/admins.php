<?php
class Admins extends CI_Model {

	function get_auth($login,$password)
	{
        $query=$this->db->get_where('users',array('login'=>$login,'password'=>$password));
		$arr=$query->result();
		if(count($arr)>0):
			return $arr[0];
		else:
			return false;
		endif;
	}

}