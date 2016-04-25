<?php
namespace Entities;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class text{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $text_id;

    /**
     * @ORM\Column(type="text", nullable=false)
     */
    private $data;

		public function __construct($data){
			$this->data = $data;
		}

		public function getData(){
			return $this->data;
		}
}
