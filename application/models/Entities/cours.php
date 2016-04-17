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
    private $data;

    /**
     * @ORM\Column(type="string", length=20, nullable=false)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="cours_passed", mappedBy="cours")
     */
    private $coursPassed;

    /**
     * @ORM\ManyToOne(targetEntity="admin", inversedBy="cours")
     * @ORM\JoinColumn(name="admin_user_id", referencedColumnName="user_id")
     */
    private $admin;
}
