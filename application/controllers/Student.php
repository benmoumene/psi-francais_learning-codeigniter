<?php
class Student extends Student_Controller{
	public function index(){
		$this->session->set_userdata('level', 'Niveau: 1');
		parent::index();
	}
}
?>
