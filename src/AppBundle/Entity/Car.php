<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Car
 *
 * @ORM\Table(name="cars")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CarRepository")
 */
class Car
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
     * @ORM\Column(name="make", type="string", length=255)
     */
    private $make;

    /**
     * @var string
     *
     * @ORM\Column(name="model", type="string", length=255)
     */
    private $model;

    /**
     * @var int
     *
     * @ORM\Column(name="TravelledDistance", type="bigint")
     */
    private $travelledDistance;

	/**
	 * @var ArrayCollection|Part[]
	 *
	 * Many Cars have Many Parts.
	 *
	 * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Part")
	 * @ORM\JoinTable(name="parts_cars",
	 *     joinColumns={@ORM\JoinColumn(name="car_id",referencedColumnName="id")},
	 *     inverseJoinColumns={@ORM\JoinColumn(name="part_id",referencedColumnName="id")})
	 */
    private $parts;

	/**
	 * Car constructor.
	 */
	public function __construct()
	{
		$this->parts = new ArrayCollection();
	}

	/**
	 * @return Part[]|ArrayCollection
	 */
	public function getParts()
	{
//		$stringPart=[];
//		foreach ($this->parts as $part){
//			/**
//			 * @var $part Part
//			 */
//			$stringPart[]=$part->getPart();
//		}
//		return $stringPart;
		return $this->parts;
	}

	/**
	 * @param Part[]|ArrayCollection $parts
	*
	 * @return Car
	 */
	public function setParts($parts): Car
	{
		$this->parts[] = $parts;
		return $this;
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
     * Set make.
     *
     * @param string $make
     *
     * @return Car
     */
    public function setMake($make)
    {
        $this->make = $make;

        return $this;
    }

    /**
     * Get make.
     *
     * @return string
     */
    public function getMake()
    {
        return $this->make;
    }

    /**
     * Set model.
     *
     * @param string $model
     *
     * @return Car
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get model.
     *
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set travelledDistance.
     *
     * @param int $travelledDistance
     *
     * @return Car
     */
    public function setTravelledDistance($travelledDistance)
    {
        $this->travelledDistance = $travelledDistance;

        return $this;
    }

    /**
     * Get travelledDistance.
     *
     * @return int
     */
    public function getTravelledDistance()
    {
        return $this->travelledDistance;
    }
	public function __toString(){
    	$make = $this->make;
    	$model = $this->model;
    	$dist = $this->travelledDistance;
    	$part=$this->parts;
		return "$make $model ($dist km) $part";
	}
}
