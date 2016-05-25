<?php
class MY_Controller extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
		$this->load->model('francais_model');
		$this->load->helper('form');
		$this->load->library('form_validation');
	}

	public function index(){
		$this->create_page();
	}

	protected function session_menu_data(){
		$data = array(
			'my_user' => $this->session->userdata('discr'),
			'my_username' => $this->session->userdata('username'),
			'my_level' => $this->session->userdata('level'),
			'my_id' => $this->session->userdata('id')
		); 
		return $data;
	}

	protected function view($body, $menu, $data = array()){
		if ( ! file_exists(APPPATH.'views/francais/'.$body.'.php')){
			// Whoops, we don't have a page for that!
			echo "WTF";
			show_404();
		}

		$this->load->view('templates/header',$data);
		$this->load->view('menu/'.$menu, $data);
		$this->load->view('francais/'.$body, $data);
		$this->load->view('templates/footer');
	}

	protected function create_page($body = null,$data = null){
		if($data == null)
			$data = $this->session_menu_data();
		if($body)
			$this->view($body, 'member', $data);
		else
			$this->view($data['my_user'], 'member', $data);
	}

	public function logout(){
		$this->session->sess_destroy();
		redirect('guest');
	}

	protected function log_info(){
		$user = $this->session->userdata('discr');
		if(!isset($user))
			$user = 'guest';
		return $user;
	}

}

class Public_Controller extends MY_Controller{
	public function __construct(){
		parent::__construct();
		if(parent::log_info() != 'guest')
			redirect($this->session->userdata('discr'));	
	}
}

class Admin_Controller extends MY_Controller{
	public function __construct(){
		parent::__construct();
		if(parent::log_info() != 'admin')
			redirect($this->session->userdata('discr'));	
		//load stuff
	}
}

class Student_Controller extends MY_Controller{
	public function __construct(){
		parent::__construct();
		if(parent::log_info() != 'student')
			redirect($this->session->userdata('discr'));	
		//load stuff
	}
}

class Professor_Controller extends MY_Controller{
	public function __construct(){
		parent::__construct();
		if(parent::log_info() != 'professor')
			redirect($this->session->userdata('discr'));	
		//load stuff
	}
}

class Chat_Controller extends MY_Controller{

	public function __construct(){
		parent::__construct();
		$who = parent::log_info();
		if($who == 'admin' || $who == 'guest')
			redirect($this->session->userdata('discr'));	
		//load stuff
	}
}
?>
