<?php
class Francais_model extends CI_Model{
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}

	public function new_user($email,$username,$password,$which_user){
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
		$em = $this->doctrine->em;
		$em->persist($user);
		$em->flush();
	}

	public function new_cours($cours_data){
		$cours = new Entities\cours($cours_data);
		$this->doctrine->em->persist($cours);
		$this->doctrine->em->flush();
	}

	public function new_text($data){
		$text = new Entities\text($data);
		$this->doctrine->em->persist($text);
		$this->doctrine->em->flush();
	}

	public function delete_cours($cours_id){
		$dql = 'DELETE FROM Entities\cours c WHERE c.cours_id = :cours_id';
    $query = $this->doctrine->em->createQuery($dql);
		$query->setParameter('cours_id',$cours_id);
		$query->getResult();
	}

	public function visible_cours($cours_id){
		$dql = 'SELECT c FROM Entities\cours c WHERE c.cours_id = :cours_id';
    $query = $this->doctrine->em->createQuery($dql);
		$query->setParameter('cours_id',$cours_id);
		$cours = $query->getResult()[0];
		$visible = $cours->getVisible() ? false : true;
		$cours->setVisible($visible);
		$this->doctrine->em->flush();
	}

	public function update_cours($cours_data){
		$dql = 'SELECT c FROM Entities\cours c WHERE c.cours_id = :cours_id';
    $query = $this->doctrine->em->createQuery($dql);
		$query->setParameter('cours_id',$cours_data['cours_id']);
		$cours = $query->getResult()[0];
		$cours->setCoursData($cours_data);
		$this->doctrine->em->flush();
	}

	public function get_all_courses(){
		$dql = 'SELECT c.cours_id,c.name,c.level,c.visible FROM Entities\cours c ORDER BY c.level';
    $query = $this->doctrine->em->createQuery($dql);
		return $query->getResult();
	}

	public function get_cours_descr($cours_id){
		$dql = 'SELECT c.description FROM Entities\cours c WHERE c.cours_id = :cours_id';
    $query = $this->doctrine->em->createQuery($dql);
		$query->setParameter('cours_id',$cours_id);
		return $query->getResult()[0]['description'];
	}

	public function user_discr($user){
		$dql = 'SELECT u FROM Entities\user u WHERE u.username = :user';
    $query = $this->doctrine->em->createQuery($dql);
    $query->setParameter('user', $user);
		$entity = $query->getResult()[0];
    return array('username' => $entity->getUsername(), 'id' => $entity->getUserId(), 'discr' => $this->doctrine->em->getClassMetadata(get_class($entity))->discriminatorValue);
	}

	public function username_check($username){
		$dql = 'SELECT 1 FROM Entities\user u WHERE u.username = :username';
    $query = $this->doctrine->em->createQuery($dql);
    $query->setParameter('username', $username);
    return !empty($query->getResult());
	}

	public function password_check($password){
		$dql = 'SELECT 1 FROM Entities\user u WHERE u.password = :password';
    $query = $this->doctrine->em->createQuery($dql);
    $query->setParameter('password', $password);
    return !empty($query->getResult());
	}
}
?>
