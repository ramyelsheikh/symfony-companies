<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Employee
 *
 * @ORM\Table(name="employee")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EmployeeRepository")
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
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank(message="name field is required")
     * @Assert\Length(
     *      min = 5,
     *      max = 255,
     *      minMessage = "name field must be at least {{ limit }} characters long",
     *      maxMessage = "name field cannot be longer than {{ limit }} characters"
     * )
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="phone_number", type="string", length=255)
     * @Assert\NotBlank(message="phone_number field is required")
     * @Assert\Length(
     *      min = 5,
     *      max = 255,
     *      minMessage = "phone_number field must be at least {{ limit }} characters long",
     *      maxMessage = "phone_number field cannot be longer than {{ limit }} characters"
     * )
     * @Assert\Regex(
     *     pattern="/[0-9+\s]?/g",
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
     * @var float
     *
     * @ORM\Column(name="salary", type="float")
     * @Assert\NotBlank(message="salary field is required")
     * @Assert\Type(
     *     type="numeric",
     *     message="salary field is not a valid number."
     * )
     */
    private $salary;

    /**
     * @var int
     *
     * @ORM\Column(name="company_id", type="integer")
     * @Assert\NotBlank(message="company_id field is required")
     * @Assert\Valid
     */
    private $companyId;

    /**
     * @ORM\ManyToOne(targetEntity="Company", inversedBy="employee")
     * @ORM\JoinColumn(name="company_id", referencedColumnName="id")
     */
    private $company;

    /**
     * @ORM\OneToMany(targetEntity="Dependant", mappedBy="employee")
     */
    private $dependants;

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
     * Set companyId.
     *
     * @param int $companyId
     *
     * @return Employee
     */
    public function setCompanyId($companyId)
    {
        $this->companyId = $companyId;

        return $this;
    }

    /**
     * Get companyId.
     *
     * @return int
     */
    public function getCompanyId()
    {
        return $this->companyId;
    }
}
