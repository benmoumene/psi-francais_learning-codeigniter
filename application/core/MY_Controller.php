<?php
class MY_Controller extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('url');
	}

	protected function session_menu_data(){
		$data = array(
			'user' => $this->session->userdata('discr'),
			'username' => $this->session->userdata('username'),
			'level' => $this->session->userdata('level')
		); 
		return $data;
	}

	protected function create_page($body = null,$data = null){
		if($data == null)
			$data = $this->session_menu_data();
		if($body)
			$this->view($body, 'member', $data);
		else
			$this->view($data['user'], 'member', $data);
	}

	public function index(){
		$this->create_page();
	}

	public function logout(){
		$this->session->sess_destroy();
		redirect('guest');
	}

	public function log_info(){
		$user = 'guest';
		$logged_in = $this->session->userdata('logged_in');
		if(isset($logged_in) && $logged_in){
			$user = $this->session->userdata('discr');
		}
		return $user;
	}

	public function view($body, $menu, $data = array()){
		if ( ! file_exists(APPPATH.'views/francais/'.$body.'.php')){
			// Whoops, we don't have a page for that!
			echo "WTF";
			show_404();
		}

		$this->load->helper('url');
		$this->load->view('templates/header',$data);
		$this->load->view('menu/'.$menu, $data);
		$this->load->view('francais/'.$body, $data);
		$this->load->view('templates/footer');
	}
}

class Public_Controller extends MY_Controller{
	public function __construct(){
		parent::__construct();
		if(parent::log_info() != 'guest')
			redirect($this->session->userdata('discr'));	
		$this->load->model('francais_model');
		$this->load->helper('form');
		$this->load->library('form_validation');
	}
}

class Admin_Controller extends MY_Controller{
	public function __construct(){
		parent::__construct();
		if(parent::log_info() != 'admin')
			redirect($this->session->userdata('discr'));	
		//load stuff
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('francais_model');
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
?>
