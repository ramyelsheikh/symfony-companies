<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Dependant
 *
 * @ORM\Table(name="dependant")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DependantRepository")
 */
class Dependant
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="phone_number", type="string", length=255)
     */
    private $phoneNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="gender", type="string", length=1)
     */
    private $gender;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_of_birth", type="date")
     */
    private $dateOfBirth;

    /**
     * @var int
     *
     * @ORM\Column(name="relation_id", type="integer")
     */
    private $relationId;

    /**
     * @var int
     *
     * @ORM\Column(name="employee_id", type="integer")
     */
    private $employeeId;

    /**
     * @ORM\ManyToOne(targetEntity="Employee", inversedBy="dependant")
     * @ORM\JoinColumn(name="employee_id", referencedColumnName="id")
     */
    private $employee;

    /**
     * @ORM\OneToOne(targetEntity="Relation")
     * @ORM\JoinColumn(name="relation_id", referencedColumnName="id")
     */
    private $relation;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Dependant
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set phoneNumber.
     *
     * @param string $phoneNumber
     *
     * @return Dependant
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get phoneNumber.
     *
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Set gender.
     *
     * @param string $gender
     *
     * @return Dependant
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender.
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set dateOfBirth.
     *
     * @param \DateTime $dateOfBirth
     *
     * @return Dependant
     */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    /**
     * Get dateOfBirth.
     *
     * @return \DateTime
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * Set employeeRelationId.
     *
     * @param int $relationId
     *
     * @return Dependant
     */
    public function setRelationId($relationId)
    {
        $this->relationId = $relationId;

        return $this;
    }

    /**
     * Get relationId
     *
     * @return int
     */
    public function getRelationId()
    {
        return $this->relationId;
    }

    /**
     * Set employeeId.
     *
     * @param int $employeeId
     *
     * @return Dependant
     */
    public function setemployeeId($employeeId)
    {
        $this->employeeId = $employeeId;

        return $this;
    }

    /**
     * Get employeeId.
     *
     * @return int
     */
    public function getemployeeId()
    {
        return $this->employeeId;
    }
}
