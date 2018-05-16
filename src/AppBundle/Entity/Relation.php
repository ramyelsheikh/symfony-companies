<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EmployeeRelation
 *
 * @ORM\Table(name="relation")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RelationRepository")
 */
class Relation
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
     * @ORM\Column(name="relation_name", type="string", length=255)
     */
    private $relationName;


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
     * Set relationName.
     *
     * @param string $relationName
     *
     * @return Relation
     */
    public function setRelationName($relationName)
    {
        $this->relationName = $relationName;

        return $this;
    }

    /**
     * Get relationName.
     *
     * @return string
     */
    public function getRelationName()
    {
        return $this->relationName;
    }
}
