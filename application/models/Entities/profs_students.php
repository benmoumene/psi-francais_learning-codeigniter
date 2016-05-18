<?php
namespace Entities;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class profs_students{
    /**
		 * @ORM\Id
     * @ORM\ManyToOne(targetEntity="student", inversedBy="profs_students")
     * @ORM\JoinColumn(name="student_user_id", referencedColumnName="user_id")
     */
    private $student;

    /**
		 * @ORM\Id
     * @ORM\ManyToOne(targetEntity="professor", inversedBy="profs_students")
     * @ORM\JoinColumn(name="professor_user_id", referencedColumnName="user_id")
     */
    private $professor;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
		private $accepted;

		public function __construct($student, $professor){
			$this->student = $student;
			$this->professor = $professor;
			$this->accepted = false;
		}

		public function getAccepted(){
			return $this->accepted;
		}

		public function setAccepted(){
			$this->accepted = true;
		}
}
