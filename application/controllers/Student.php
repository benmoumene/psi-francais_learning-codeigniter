<?php
class Student extends Student_Controller{

	public function index(){
		if(is_null($this->session->userdata('level')))
			$this->session->set_userdata('level',$this->francais_model->get_user_level($this->session->userdata('id')));
		parent::create_page();
	}

	public function show_courses(){
		$data = parent::session_menu_data();
		$data['courses'] = $this->francais_model->get_courses($this->session->userdata('id'), $this->session->userdata('id'));
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
			$this->francais_model->course_solved($this->session->userdata('id'),$this->session->userdata('cours_id'));
			$this->session->unset_userdata('cours_id');
			parent::create_page('cours_solved');
		}
	}

	public function _check_field($input_solution, $solution){
		if(trim($input_solution) == $solution || $solution == "*")
			return true;
		return false;
	}

	public function show_students(){
		//TO DO: show students below and on current student level
	}
	
	public function show_professors(){
		//TO DO: show professors below and on current student level
	}

	public function read_text(){
		//TO DO: input french text for reading(interactively)
	}

	public function read_interactive_text(){
		//TO DO: read interactively
	}
}
?>
