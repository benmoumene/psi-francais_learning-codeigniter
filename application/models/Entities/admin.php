<?php
namespace Entities;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class admin extends user{
	/**
	 * @ORM\OneToMany(targetEntity="cours", mappedBy="admin")
	 */
	private $cours;

	public function __construct($email,$username,$password){
		parent::__construct($email,$username,$password);
	}

	public function getDiscr(){
		return 'admin';
	}
}
