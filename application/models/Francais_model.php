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
