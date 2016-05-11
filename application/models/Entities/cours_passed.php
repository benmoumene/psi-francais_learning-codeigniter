<?php
namespace Entities;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class cours_passed{
    /**
		 * @ORM\Id
     * @ORM\ManyToOne(targetEntity="student", inversedBy="coursPassed")
     * @ORM\JoinColumn(name="student_user_id", referencedColumnName="user_id")
     */
    private $student;

    /**
		 * @ORM\Id
     * @ORM\ManyToOne(targetEntity="cours", inversedBy="coursPassed")
     * @ORM\JoinColumn(name="cours_id", referencedColumnName="cours_id")
     */
    private $cours;

		public function __construct($student, $cours){
			$this->student = $student;
			$this->cours = $cours;
		}
		
		public function getId(){
			return array($student->getId(),$cours->getId());
		}
}
