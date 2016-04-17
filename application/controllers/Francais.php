<?php
class Francais extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('francais_model');
	}

	public function view($page,$menu){
		if ( ! file_exists(APPPATH.'views/francais/'.$page.'.php')){
			// Whoops, we don't have a page for that!
			show_404();
		}

		$data['title'] = ucfirst($page); // Capitalize the first letter

		$this->load->helper('url');
		$this->load->view('templates/header', $data);
		$this->load->view('templates/menu_'.$menu);
		$this->load->view('francais/'.$page, $data);
		$this->load->view('templates/footer', $data);
	}

	public function register(){
		$this->load->helper(array('form', 'url'));

		$this->load->library('form_validation');
		$this->form_validation->set_rules('email','Email','required|valid_email|is_unique[user.email]');
		$this->form_validation->set_rules('username','Username','required|min_length[5]|max_length[12]|is_unique[user.username]');
		$this->form_validation->set_rules('password','Password','required|min_length[4]|max_length[15]');
		$this->form_validation->set_rules('passconf','Password Confirmation','required|matches[password]');
		
		if ($this->form_validation->run() == FALSE)
			$this->view("register",'login');
		else{
			//$this->francais_model->new_user(set_value('email'),set_value('username'),set_value('password'),set_value('reg_who'));
			$this->view('register_success','login');
		}
	}
}
?>
