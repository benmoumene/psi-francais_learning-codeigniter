<?php
class Francais_model extends CI_Model{
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function new_user($email,$username,$password,$which_user){
		$em = $this->doctrine->em;
		switch($which_user){
			case 'e':
				$user = new Entities\student($email,$username,$password);
				break;
			case 'p':
				$user = new Entities\professor($email,$username,$password);
				break;
			case 'a':
				$user = new Entities\admin($email,$username,$password);
				break;
			default:
				$user = null;
		}
		$em->persist($user);
		$em->flush();
	}
}
?>
