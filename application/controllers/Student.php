<?php
class Student extends Student_Controller{

	public function index(){
		if(is_null($this->session->userdata('level')))
			$this->session->set_userdata('level',$this->francais_model->get_user_level($this->session->userdata('id')));
		parent::create_page();
	}

	public function show_courses(){
		$data = parent::session_menu_data();
		$data['courses'] = $this->francais_model->get_courses($this->session->userdata('id'), $this->session->userdata('level'));
		parent::create_page('my_courses',$data);
	}

	public function set_cours_id(){
		$this->session->set_userdata('cours_id', set_value('cours_id'));
	}

	public function solve_cours(){
		$data = array_merge(parent::session_menu_data(), $this->francais_model->get_cours_info($this->session->userdata('cours_id')));
		parent::create_page('cours_to_solve',$data);
	}

	public function check_cours(){
		$cours_fields = $this->francais_model->get_cours_solutions($this->session->userdata('cours_id'));
		foreach($cours_fields as $name => $solution)
			$this->form_validation->set_rules(strtolower($name), ucfirst($name), 'required|callback__check_field['.$solution.']');
		if($this->form_validation->run() == FALSE)
			$this->solve_cours();
		else{
			$cours_passed = $this->francais_model->course_solved($this->session->userdata('id'),$this->session->userdata('cours_id'));
			if($cours_passed != 0 && $cours_passed % 2 === 0){
				$new_level = $this->francais_model->increment_level($this->session->userdata('id'));
				$this->session->set_userdata('level',$new_level);
				// $this->francais_model->inform_professors($this->session->userdata('id'));
			}
			parent::create_page('cours_solved');
		}
	}

	public function _check_field($input_solution, $solution){
		if(trim($input_solution) == $solution || $solution == "*")
			return true;
		return false;
	}

	public function show_students(){
		$data = parent::session_menu_data();
		$data['users'] = $this->francais_model->get_students($this->session->userdata('id'), $this->session->userdata('level'));
		$data['show'] = 'students';
		parent::create_page("my_users",$data);
	}

	public function show_student(){
		$data = array_merge(parent::session_menu_data(),$this->francais_model->get_student($this->session->userdata('user_id')));
		parent::create_page("my_user",$data);
	}
	
	public function show_professors(){
		$data = parent::session_menu_data();
		$data['users'] = $this->francais_model->get_professors($this->session->userdata('level'));
		$data['show'] = 'professors';
		parent::create_page("my_users",$data);
	}

	public function show_professor(){
		$data = array_merge(parent::session_menu_data(),$this->francais_model->get_professor($this->session->userdata('id'),$this->session->userdata('user_id')));
		parent::create_page("my_professor",$data);
	}

	public function send_request(){
		$this->francais_model->set_request($this->session->userdata('id'),set_value('prof_id'));
	}

	public function set_user_id(){
		$this->session->set_userdata('user_id', set_value('user_id'));
	}

	public function read_text(){
		parent::create_page("my_text");
	}

	public function read_interactive_text(){
		$data = parent::session_menu_data();
		$data['words'] = explode(' ',set_value('text'));
		parent::create_page("my_inter_text",$data);
	}

	public function check_word(){
		$params = [
				'index' => 'dict',
				'type' => 'type_fr',
				'body' => [
						'query' => [
								'match' => [
										'word' => trim(set_value('word'))
								]
						]
				]
		];
		$response = $this->elasticsearch->client->search($params);

		if(isset($response['hits']['hits'][0]))
			foreach($response['hits']['hits'] as $hit)
				echo '<hr>'.htmlspecialchars($hit['_source']['translation']."\n");
		else
			echo '<hr>Pas de définition trouvée.';
	}

	public function update_info(){
		parent::create_page('update_info');
	}

	public function set_info(){
		$this->francais_model->set_user_info($this->session->userdata('id'), set_value('surname'), set_value('name'), set_value('city'), set_value('profession'));
		parent::create_page('info_added');
	}
}
?>
