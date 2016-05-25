<?php
class Guest extends Public_Controller{

	public function index($body = null){
		$data['my_user'] = 'guest';
		if(is_null($body))
			$body = 'register';
		parent::view($body,'login',$data);
	}

	public function register(){
		$this->form_validation->set_rules('email','Email','required|valid_email|is_unique[user.email]');
		$this->form_validation->set_rules('username','Username','required|min_length[5]|max_length[12]|is_unique[user.username]');
		$this->form_validation->set_rules('password','Password','required|min_length[4]|max_length[15]');
		$this->form_validation->set_rules('passconf','Password Confirmation','required|matches[password]');
		
		if ($this->form_validation->run() == FALSE)
			$this->index();
		else{
			$this->francais_model->new_user(set_value('email'),set_value('username'),set_value('password'),set_value('reg_who'));
			$this->index('register_success');
		}
	}

	public function login(){
		$this->form_validation->set_rules('login_username','LogInUsername','required|min_length[5]|max_length[12]|callback__username_check');
		$this->form_validation->set_rules('login_password','LogInPassword','required|min_length[4]|max_length[15]|callback__password_check');

		if($this->form_validation->run() == FALSE)
			$this->index();
		else{
			$user_data = $this->francais_model->get_user_discr(set_value('login_username'));
			$this->session->set_userdata($user_data);
			redirect($user_data['discr']);
		}
	}

	/*Another option would be to prepend an underscore to the callback function name, which is a little CI-specific "trick" to make a public method unaccessible from the URI. username_check would become _username_check, and the callback name would use double underscores: callback__username_check*/
	public function _username_check($str){
		return $this->francais_model->username_check($str);
	}
	
	public function _password_check($str){
		return $this->francais_model->password_check($str);
	}
}
