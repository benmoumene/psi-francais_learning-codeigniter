<?php
namespace Entities;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class message
{
	
	/**
	 * @ORM\Id
	 * @ORM\ManyToOne(targetEntity="communication", inversedBy="message")
	 * @ORM\JoinColumn(name="id_communication", referencedColumnName="id_communication")
	 */
	private $communication;


	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer", nullable=false)
	 */
	private $sender;


	/**
	 * @ORM\Column(type="text", nullable=false)
	 */
	private $data;

	/**
	 * @ORM\Column(type="datetime", nullable=false)
	 * @ORM\Version
	 * @var string
	 */
	 private $time;

	public function __construct($communication, $sender, $data){
		$this->communication = $communication;
		$this->sender = $sender;
		$this->data = $data;
	}
}
