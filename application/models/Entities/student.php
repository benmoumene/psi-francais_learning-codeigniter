<?php
namespace Entities;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class student extends user
{
	/**
	 * @ORM\Column(type="integer", nullable=false)
	 */
	private $level;

	/**
	 * @ORM\Column(type="string", length=20, nullable=true)
	 */
	private $name;

	/**
	 * @ORM\Column(type="string", length=20, nullable=true)
	 */
	private $surname;

	/**
	 * @ORM\Column(type="string", length=20, nullable=true)
	 */
	private $city;

	/**
	 * @ORM\Column(type="string", length=30, nullable=true)
	 */
	private $profession;

	/**
	 * @ORM\OneToMany(targetEntity="cours_passed", mappedBy="student")
	 */
	private $coursPassed;

	/**
	 * @ORM\OneToMany(targetEntity="cours_passed", mappedBy="student")
	 */
	private $profs_students;

	public function __construct($email,$username,$password){
		parent::__construct($email,$username,$password);
		$this->level = 1;
	}
	
	public function getName(){
		return $this->name;
	}

	public function getSurname(){
		return $this->surname;
	}

	public function getCity(){
		return $this->city;
	}

	public function getProffesion(){
		return $this->proffesion;
	}

	public function getLevel(){
		return $this->level;
	}

	public function getDiscr(){
		return 'student';
	}

	public function setDescription($name,$surname,$city,$profession){
		$this->name = $name;
		$this->surname = $surname;
		$this->city = $city;
		$this->profession = $profession;
	}
}
