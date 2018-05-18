<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Employee
 *
 * @ORM\Table(name="employee")
 * @ORM\Entity
 */
class Employee
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

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
    protected $name;

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
    protected $phoneNumber;

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
    protected $gender;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_of_birth", type="date")
     * @Assert\NotBlank(message="date_of_birth field is required")
     * @Assert\Date(
     *     message = "date field format must be 'YYYY-MM-DD'"
     * )
     */
    protected $dateOfBirth;

    /**
     * @var float
     *
     * @ORM\Column(name="salary", type="float")
     * @Assert\NotBlank(message="salary field is required")
     * @Assert\Type(
     *     type="numeric",
     *     message="salary field is not a valid number."
     * )
     */
    protected $salary;

    /**
     * @ORM\ManyToOne(targetEntity="Company", inversedBy="employee")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     */
    protected $company;

    /**
     * @ORM\OneToMany(targetEntity="Dependant", mappedBy="employee")
     */
    protected $dependants;

    /**
     * Employee constructor.
     */
    public function __construct()
    {
        $this->dependants = new ArrayCollection();
    }

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
     * @return Employee
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
     * @return Employee
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
     * @return Employee
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
     * @return Employee
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
     * Set salary.
     *
     * @param float $salary
     *
     * @return Employee
     */
    public function setSalary($salary)
    {
        $this->salary = $salary;

        return $this;
    }

    /**
     * Get salary.
     *
     * @return float
     */
    public function getSalary()
    {
        return $this->salary;
    }

    /**
     * @param Company $company
     *
     * @return $this
     */
    public function setCompany(Company $company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return Company
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @return array
     */
    public function getDependants()
    {
        return $this->dependants->toArray();
    }

    /**
     * @param Dependant $dependant
     *
     * @return $this
     */
    public function addDependant(Dependant $dependant)
    {
        $this->dependants->add($dependant);

        return $this;
    }


}
