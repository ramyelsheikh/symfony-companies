<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 5,
     *      max = 255
     * )
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="phone_number", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 5,
     *      max = 255
     * )
     * @Assert\Regex(
     *     pattern="/^[0-9+\s]*$/",
     *     message="phone number pattern can contain only numbers, '+' and spaces"
     * )
     */
    private $phoneNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="gender", type="string", length=1)
     * @Assert\NotBlank(message="gender field is required")
     * @Assert\Choice(
     *     choices = { "m", "f"},
     *     message = "Choose a valid gender. either 'm' or 'f'"
     * )
     */
    private $gender;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_of_birth", type="date")
     * @Assert\NotBlank(message="date_of_birth field is required")
     * @Assert\Date(
     *     message = "date field format must be 'YYYY-MM-DD'"
     * )
     */
    private $dateOfBirth;

    /**
     * @var int
     *
     * @ORM\Column(name="relation_id", type="integer")
     * @Assert\NotBlank(message="relation_id field is required")
     */
    private $relationId;

    /**
     * @var int
     *
     * @ORM\Column(name="employee_id", type="integer")
     * @Assert\NotBlank(message="employee_id field is required")
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

    /**
     * Set Employee.
     *
     * @param \AppBundle\Entity\Employee $employee
     *
     * @return Dependant
     */
    function setEmployee(\AppBundle\Entity\Employee $employee)
    {
        $this->employee = $employee;

        return $this;
    }

    /**
     * Set Relation.
     *
     * @param \AppBundle\Entity\Relation $relation
     *
     * @return Dependant
     */
    function setRelation(\AppBundle\Entity\Relation $relation)
    {
        $this->relation = $relation;

        return $this;
    }
}
