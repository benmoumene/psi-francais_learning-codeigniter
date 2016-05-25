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
		$cours = $this->doctrine->em->find('Entities\cours', $cours_id);
		$visible = $cours->getVisible() ? false : true;
		$cours->setVisible($visible);
		$this->doctrine->em->flush();
	}

	public function update_cours($cours_data){
		$cours = $this->doctrine->em->find('Entities\cours', $cours_data['cours_id']);
		$cours->setCoursData($cours_data);
		$this->doctrine->em->flush();
	}

	public function get_all_courses(){
		$dql = 'SELECT c.cours_id,c.name,c.level,c.visible FROM Entities\cours c ORDER BY c.level';
    $query = $this->doctrine->em->createQuery($dql);
		return $query->getResult();
	}

	public function get_courses($student_id, $level){
		$dql = 'SELECT c.cours_id,c.name,c.level FROM Entities\cours c WHERE c.level <= :level and c.visible = 1';
		$query = $this->doctrine->em->createQuery($dql);
		$query->setParameter('level',$level);
		$courses = $query->getResult();
		foreach($courses as $key => $cours){
			$index = array('student' => $student_id, 'cours' => $cours['cours_id']);
			// usage of proxy (?!)
			$courses[$key]['solved'] = $this->doctrine->em->getRepository('Entities\cours_passed')->findOneBy($index) ? true : false;
		}
		return $courses;
	}

	public function get_cours_descr($cours_id){
		$cours = $this->doctrine->em->find('Entities\cours', $cours_id);
		return $cours->getDescription();
	}

	public function get_cours_info($cours_id){
		$dql = 'SELECT c.cours_id,c.name,c.data FROM Entities\cours c WHERE c.cours_id = :cours_id';
    $query = $this->doctrine->em->createQuery($dql);
		$query->setParameter('cours_id',$cours_id);
		return $query->getResult()[0];
	}

	public function get_cours_solutions($cours_id){
		$cours = $this->doctrine->em->find('Entities\cours', $cours_id);
		return $cours->getSolutions();
	}

	public function course_solved($student_id, $cours_id){
		$student = $this->doctrine->em->find('Entities\student', $student_id);
		$cours = $this->doctrine->em->find('Entities\cours', $cours_id);
		$cours_passed = new Entities\cours_passed($student, $cours);
		$this->doctrine->em->persist($cours_passed);
		try{
				$this->doctrine->em->flush();
		}
		catch( \Doctrine\DBAL\DBALException $e ){
			if( $e->getPrevious()->getCode() === '23000' ) { 
				//echo "cours alraedy solved"
				return 0;
			} 
		}
		$query = $this->doctrine->em->createQuery('SELECT COUNT(cp.student) FROM Entities\cours_passed cp WHERE cp.student = :student_id');
		$query->setParameter('student_id',$student_id);
		return $query->getSingleScalarResult();
	}

	public function increment_level($user_id){
		$user = $this->doctrine->em->find('Entities\student', $user_id);
		if(is_null($user)){
			$user = $this->doctrine->em->find('Entities\professor', $user_id);
		}
		$user_level = $user->getLevel();
		$user->setLevel(++$user_level);
		$this->doctrine->em->flush();
		return $user_level;
	}

	public function get_students($student_id, $level){
		$dql = 'SELECT s.user_id,s.username FROM Entities\student s WHERE s.user_id <> :student_id and s.level <= :level';
		$query = $this->doctrine->em->createQuery($dql);
		$query->setParameters(array('student_id' => $student_id, 'level' => $level));
		return $query->getResult();
	}

	public function get_student($student_id){
		$dql = 'SELECT s.user_id,s.username,s.name,s.surname,s.city,s.profession,s.level FROM Entities\student s WHERE s.user_id = :student_id';
    $query = $this->doctrine->em->createQuery($dql);
		$query->setParameter('student_id',$student_id);
		return $query->getResult()[0];
	}
	
	public function get_professors($level){
		$dql = 'SELECT p.user_id,p.username FROM Entities\professor p WHERE p.level <= :level';
		$query = $this->doctrine->em->createQuery($dql);
		$query->setParameter('level', $level);
		return $query->getResult();
	}

	public function get_professor($student_id, $professor_id){
		//get professors details
		$dql = 'SELECT p.user_id,p.username,p.name,p.surname,p.city,p.profession,p.level FROM Entities\professor p WHERE p.user_id = :professor_id';
    $query = $this->doctrine->em->createQuery($dql);
		$query->setParameter('professor_id',$professor_id);
		$data = $query->getResult()[0];

		//check if help request is sent or accepted
		$index = array('student' => $student_id, 'professor' => $professor_id);
		// usage of proxy (?!)
		$request = $this->doctrine->em->getRepository('Entities\profs_students')->findOneBy($index);
		if(isset($request))
			$data['accepted'] = $request->getAccepted();

		return $data;
	}

	public function set_request($student_id, $professor_id){
		$student = $this->doctrine->em->find('Entities\student', $student_id);
		$professor = $this->doctrine->em->find('Entities\professor', $professor_id);
		$request = new Entities\profs_students($student,$professor);
		$this->doctrine->em->persist($request);
		try{
				$this->doctrine->em->flush();
		}
		catch( \Doctrine\DBAL\DBALException $e ){
			if( $e->getPrevious()->getCode() === '23000' ) { 
				//echo "request already sent"
			} 
		}
	}

	public function accept_request($professor_id,$student_id){
		$index = array('student' => $student_id, 'professor' => $professor_id);
		// usage of proxy (?!)
		$request = $this->doctrine->em->getRepository('Entities\profs_students')->findOneBy($index);
		$request->setAccepted();
		$this->doctrine->em->flush();
	}

	public function get_my_requests($professor_id){
		$dql = 'SELECT s.user_id,s.username,s.level FROM Entities\student s JOIN Entities\profs_students ps WHERE ps.professor = :professor_id and ps.accepted = 0 and ps.student = s.user_id';
		$query = $this->doctrine->em->createQuery($dql);
		$query->setParameter('professor_id', $professor_id);
		return $query->getResult();
	}

	public function get_my_students($professor_id){
		$dql = 'SELECT s.user_id,s.username,s.name,s.surname,s.city,s.profession,s.level FROM Entities\student s JOIN Entities\profs_students ps WHERE ps.professor = :professor_id and ps.accepted = 1 and s.user_id = ps.student';
		$query = $this->doctrine->em->createQuery($dql);
		$query->setParameter('professor_id', $professor_id);
		return $query->getResult();
	}

	public function get_user_level($user_id){
		$user = $this->doctrine->em->find('Entities\student', $user_id);
		if(is_null($user)){
			$user = $this->doctrine->em->find('Entities\professor', $user_id);
		}
		return $user->getLevel();
	}

	public function get_user_info($user_id){
		$user = $this->doctrine->em->find('Entities\user', $user_id);
		return array('id' => $user->getUserId(), 'username' => $user->getUsername(), 'discr' => $this->doctrine->em->getClassMetadata(get_class($user))->discriminatorValue);
	}

	public function get_user_discr($user){
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

	public function new_message($id_communication, $sender, $data){
		$communication = $this->doctrine->em->find('Entities\communication', $id_communication);
		$message = new Entities\message($communication,$sender,$data);
		$this->doctrine->em->persist($message);
		$this->doctrine->em->flush();
	}

	public function get_messages($id_communication){
		$dql = 'SELECT m.sender,m.data,m.time FROM Entities\message m where m.communication = :id_communication ORDER BY m.time';//limit with some number depends on the textarea size
    $query = $this->doctrine->em->createQuery($dql)/* ->setMaxResults(1000)->setFirstResult(10) */;
		$query->setParameter('id_communication', $id_communication);
		return $query->getResult();
	}

	public function get_chat($user_id_zero,$user_id_one){
		$dql = 'SELECT c.id_communication FROM Entities\communication c where (c.user_zero = :user_id_zero and c.user_one = :user_id_one) or (c.user_zero = :user_id_one and c.user_one = :user_id_zero)';
    $query = $this->doctrine->em->createQuery($dql);
		$query->setParameters(array('user_id_zero' => $user_id_zero, 'user_id_one' => $user_id_one));
		$result = $query->getResult(); 
		if(!empty($result))
			return $result[0]['id_communication'];
		$user_zero = $this->doctrine->em->find('Entities\user', $user_id_zero);
		$user_one = $this->doctrine->em->find('Entities\user', $user_id_one);
		$communication = new Entities\communication($user_zero,$user_one);
		$this->doctrine->em->persist($communication);
		$this->doctrine->em->flush();
		return $communication->getIdCommunication();
	}
}
?>
