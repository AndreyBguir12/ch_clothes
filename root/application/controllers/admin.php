<?php
class Admin extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('admins');
	}
	
	function index()
	{
		$this->load->view('admin/login',array());
	}
	
	function login()
	{
		$login=$this->input->post('fldLogin');
		$password=$this->input->post('fldPassword');
		$currentUser=$this->admins->get_auth($login,$password);
		if(!$currentUser):
			redirect('/admin','refresh');
		else:
			$this->session->set_userdata(array(
					'logged'=>TRUE,
					'userId'=>$currentUser->id
				)
			);
			redirect('/adminwork/bids','refresh');
		endif;
	}
	
	function logout()
	{
		$this->session->sess_destroy();
		redirect('/catalog','refresh');
	}
	
}