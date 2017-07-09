<?php
/**
 * Created by PhpStorm.
 * User: BaTryXaaa
 * Date: 7/7/2017
 * Time: 13:57
 */

namespace AppBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GenusRepository")
 * @ORM\Table(name="genus")
 */
class Genus
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\SubFamily")
     * @ORM\JoinColumn(nullable=false)
     */
    private $subFamily;

    /**
     * @Assert\NotBlank()
     * @Assert\Range(min = 0, minMessage="Negative species! Come on... ")
     * @ORM\Column(type="integer")
     */
    private $speciesCount;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\GenusNote", mappedBy="genus")
     * @ORM\OrderBy({"createdAt"="DESC"})
     */
    private $notes;

    public function __construct()
    {
        $this->notes = new ArrayCollection();
    }

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="date")
     */
    private $firstDiscoveredAt;

    /**
     * @return mixed
     */
    public function getFirstDiscoveredAt()
    {
        return $this->firstDiscoveredAt;
    }

    /**
     * @param mixed $firstDiscoveredAt
     */
    public function setFirstDiscoveredAt($firstDiscoveredAt)
    {
        $this->firstDiscoveredAt = $firstDiscoveredAt;
    }

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $funFact;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPublished = true;


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getSubFamily()
    {
        return $this->subFamily;
    }

    /**
     * @param mixed $subFamily
     */
    public function setSubFamily(SubFamily $subFamily = null)
    {
        $this->subFamily = $subFamily;
    }

    /**
     * @return mixed
     */
    public function getSpeciesCount()
    {
        return $this->speciesCount;
    }

    /**
     * @param mixed $speciesCount
     */
    public function setSpeciesCount($speciesCount)
    {
        $this->speciesCount = $speciesCount;
    }

    /**
     * @return mixed
     */
    public function getFunFact()
    {
        return $this->funFact;
    }

    /**
     * @param mixed $funFact
     */
    public function setFunFact($funFact)
    {
        $this->funFact = $funFact;
    }

    public function getUpdatedAt() {
        return new \DateTime('-'.rand(1,100).' days');
    }

    /**
     * @return mixed
     */
    public function getIsPublished()
    {
        return $this->isPublished;
    }

    /**
     * @param mixed $isPublished
     */
    public function setIsPublished($isPublished)
    {
        $this->isPublished = $isPublished;
    }

    /**
     * @return arrayCollection|GenusNote[]
     */
    public function getNote()
    {
        return $this->notes;
    }

}