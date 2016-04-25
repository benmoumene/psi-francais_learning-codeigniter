<?php
namespace Entities;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class cours
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $cours_id;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $level;


    /**
     * @ORM\Column(type="text", nullable=false)
     */
    private $description;

    /**
     * @ORM\Column(type="text", nullable=false)
     */
    private $data;

    /**
     * @ORM\Column(type="string", length=250, nullable=false)
     */
		private $solutions;

    /**
     * @ORM\Column(type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
		 private $visible;

    /**
     * @ORM\OneToMany(targetEntity="cours_passed", mappedBy="cours")
     */
    private $coursPassed;

    /**
     * @ORM\ManyToOne(targetEntity="admin", inversedBy="cours")
     * @ORM\JoinColumn(name="admin_user_id", referencedColumnName="user_id")
     */
    private $admin;

		public function __construct($cours_data){
			$this->setCoursData($cours_data);
		}

		public function getName(){
			return $this->name;
		}

		public function getLevel(){
			return $this->level;
		}

		public function getSolutions(){
			parse_str($solutions,$cours_fields);
			return $cours_fields;
		}

		public function getData(){
			return $this->data;
		}

		public function getVisible(){
			return $this->visible;
		}

		public function setVisible($visible){
			$this->visible = $visible;
		}

		public function setCoursData($cours_data){
			$this->name = $cours_data['cours_name'];
			$this->level = $cours_data['cours_level'];
			$this->visible = $cours_data['visible'];
			$this->solutions = http_build_query($cours_data['fields']);
			$this->description = $cours_data['cours_descr'];
			$this->data = $cours_data['cours_data'];
		}
}
