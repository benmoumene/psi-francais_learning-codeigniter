<?php
class Admin extends Admin_Controller{

	private $level_pattern = '/Niveau ?= ?([0-9]{1,}) ?;/';
	private $name_pattern = '/Nom_du_Cours ?= ?(.*) ?;/';
	private $input_pattern = '/\|input\-(.*)\-(.*)\|/';
	private $visible_pattern = '/Visible ?= ?(true|false) ?;/';

	public function index(){
		$this->session->unset_userdata('cours_id');
		parent::index();
	}

	public function add_cours(){
		$data = parent::session_menu_data();
		$data['cours_id'] = $this->session->userdata('cours_id');
		$data['cours_descr'] = set_value('cours_descr');
		if(empty($data['cours_descr']) && !empty($data['cours_id']))
			$data['cours_descr'] = $this->francais_model->get_cours_descr($data['cours_id']);
		parent::create_page('add_cours',$data);
	}

	public function submit_cours(){
		$this->form_validation->set_rules('cours_descr','CoursDescription','required|callback__cours_check');

		if($this->form_validation->run() == FALSE)
			$this->add_cours();
		else{
			$cours_data = $this->extract_cours_data(set_value('cours_descr'));
			$cours_data['cours_id'] = $this->session->userdata('cours_id');
			$this->create_cours($cours_data);
			$data = array_merge(parent::session_menu_data(),$cours_data);
			parent::create_page('cours_look',$data);
		}
	}

	public function add_text(){
		$data = parent::session_menu_data();
		$data['text'] = set_value('my_text');
		parent::create_page('add_text',$data);
	}

	public function submit_text(){
		$this->form_validation->set_rules('my_text','MyText','required');

		if($this->form_validation->run() == FALSE)
			$this->add_text();
		else{
			$this->francais_model->new_text(set_value('my_text'));
			$data = parent::session_menu_data();
			parent::create_page('text_added',$data);
		}
	}

	public function mody_cours(){
		$data = parent::session_menu_data();
		$data['courses'] = $this->francais_model->get_all_courses();
		parent::create_page('mody_cours',$data);
	}

	public function add_admin(){
		$this->form_validation->set_rules('email','Email','required|valid_email|is_unique[user.email]');
		$this->form_validation->set_rules('username','Username','required|min_length[5]|max_length[12]|is_unique[user.username]');
		$this->form_validation->set_rules('password','Password','required|min_length[4]|max_length[15]');
		$this->form_validation->set_rules('passconf','Password Confirmation','required|matches[password]');
		
		if ($this->form_validation->run() == FALSE){
			$data = parent::session_menu_data();
			parent::create_page('admin_reg',$data);
		}
		else{
			$this->francais_model->new_user(set_value('email'),set_value('username'),set_value('password'),'a');
			$data = parent::session_menu_data();
			parent::create_page('admin_success',$data);
		}
	}

	public function set_cours_id(){
		$this->session->set_userdata('cours_id',set_value('cours_id'));
	}

	public function delete_cours(){
		$this->francais_model->delete_cours(set_value('cours_id'));
	}

	public function visible_cours(){
		$this->francais_model->visible_cours(set_value('cours_id'));
	}

	private function extract_cours_data($cours_descr){
		preg_match($this->level_pattern, $cours_descr, $level);
		preg_match($this->name_pattern, $cours_descr, $cours_name);
		preg_match($this->visible_pattern, $cours_descr, $visible);
		preg_match_all($this->input_pattern, $cours_descr, $input);
		$visible =  $visible[1] === 'true' ? true: false;

		//build associtave array with field names and solutions
		$cours_fields = array_combine($input[2],$input[1]);

		//remove level and name information from cours data
		$cours_data = $this->update_header($cours_descr);

		//change input with real html input
		$cours_data = $this->update_input($cours_data,array_keys($cours_fields));

		return array('cours_name' => $cours_name[1],'cours_level' => $level[1], 'visible' => $visible, 'fields' => $cours_fields, 'cours_descr' => $cours_descr, 'cours_data' => $cours_data);
	}

	private function create_cours($cours_data){
		if(!empty($cours_data['cours_id']))
			$this->francais_model->update_cours($cours_data);
		else
			$this->francais_model->new_cours($cours_data);
	}

	public function _cours_check($cours_descr){
		$pattern_arr = array($this->level_pattern, $this->name_pattern, $this-> input_pattern, $this->visible_pattern);
		foreach($pattern_arr as $pattern)
			if(!preg_match($pattern,$cours_descr))
				return false;	
		return true;
	}

	private function update_input($cours_descr,$cours_fields){
		foreach($cours_fields as $field){
			/*if($input[1][?] == 'checkbox'){
				...
			}*/
			$data = array(
								'name' => strtolower($field),
								'type' => 'text',
								'class' => "regular",
								'placeholder' => $field,
								'size' => strlen($field),
							);
			$input_pattern = "/\|input\-(.*)\-$field\|/";
			$cours_descr = preg_replace($input_pattern,form_input($data),$cours_descr);
		}
		return $cours_descr;
	}

	private function update_header($cours_descr){
		$pattern_arr = array($this->level_pattern, $this->name_pattern, $this->visible_pattern);
		foreach($pattern_arr as $pattern)
			$cours_descr = preg_replace($pattern,'',$cours_descr);
		return nl2br(ltrim($cours_descr));
	}
}
?>
