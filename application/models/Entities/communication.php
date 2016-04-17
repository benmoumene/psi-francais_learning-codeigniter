<?php
namespace Entities;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity
 */
class communication
{
    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $data;

    /**
     * @ORM\ManyToOne(targetEntity="student", inversedBy="communication")
     * @ORM\JoinColumn(name="student_user_id", referencedColumnName="user_id")
     */
    private $student;

    /**
     * @ORM\ManyToOne(targetEntity="user", inversedBy="communicationStdProf")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
     */
    private $user;
}
