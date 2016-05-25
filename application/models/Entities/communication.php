<?php
namespace Entities;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class communication
{
		
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer", nullable=false)
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	private $id_communication;
	/**
	 * @ORM\ManyToOne(targetEntity="user", inversedBy="communication")
	 * @ORM\JoinColumn(name="user_id_zero", referencedColumnName="user_id")
	 */
	private $user_zero;

	/**
	 * @ORM\ManyToOne(targetEntity="user", inversedBy="communication")
	 * @ORM\JoinColumn(name="user_id_one", referencedColumnName="user_id")
	 */
	private $user_one;

	/**
	 * @ORM\OneToMany(targetEntity="message", mappedBy="communication")
	 */
	private $message;

	public function __construct($user_zero,$user_one){
		$this->user_zero = $user_zero;
		$this->user_one = $user_one;
	}

	public function getIdCommunication(){
		return $this->id_communication;
	}
}
