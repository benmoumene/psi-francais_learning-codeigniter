<?php
class Professor extends Professor_Controller{
	public function index(){
		if(is_null($this->session->userdata('level')))
			$this->session->set_userdata('level',$this->francais_model->get_user_level($this->session->userdata('id')));
		parent::index();
	}

	public function my_requests(){
		$data = parent::session_menu_data();
		$data['users'] = $this->francais_model->get_my_requests($this->session->userdata('id'));
		$data['show'] = 'students_req';
		 parent::create_page("my_users_p",$data);
	}

	public function show_student_requests(){
		$data = array_merge(parent::session_menu_data(),$this->francais_model->get_student($this->session->userdata('user_id')));
		parent::create_page("my_student",$data);
	}

	public function accept_request(){
		$this->francais_model->accept_request($this->session->userdata('id'),$this->session->userdata('user_id'));
		parent::create_page("accepted_request");
	}
	
	public function set_user_id(){
		$this->session->set_userdata('user_id',set_value('user_id'));
	}

	public function my_students(){
		$data = array_merge(parent::session_menu_data());
		$data['users'] = $this->francais_model->get_my_students($this->session->userdata('id'));
		$data['show'] = 'students';
		parent::create_page("my_users_p",$data);
	}

	public function show_student(){
		$data = array_merge(parent::session_menu_data(),$this->francais_model->get_student($this->session->userdata('user_id')));
		parent::create_page("my_user",$data);
	}
}
?>
