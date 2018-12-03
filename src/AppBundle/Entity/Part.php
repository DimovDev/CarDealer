<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Part
 *
 * @ORM\Table(name="parts")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PartRepository")
 * @method getPart()
 */
class Part
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
     * @ORM\Column(name="price", type="decimal", precision=10, scale=2)
     */
    private $price;

    /**
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

	/**
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Supplier",inversedBy="parts")
	 */
    private $supplier;

	/**
	 * @var ArrayCollection|Car []
	 *
	 * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Part",mappedBy="parts")
	 */
    private $cars;

	/**
	 * Part constructor.
	 */
	public function __construct()
	{
		$this->cars = new ArrayCollection();
	}

	/**
	 * @return mixed
	 */
	public function getSupplier()
	{
		return $this->supplier;
	}

	/**
	 * @param mixed $supplier

	 * @return Part
	 */
	public function setSupplier($supplier): Part
	{
		$this->supplier = $supplier;
		return $this;
	}

//	/**
//	 * @return Car[]|ArrayCollection
//	 */
//	public function getCars()
//	{
//		return $this->cars;
//	}
//
//	/**
//	 * @param Car[]|ArrayCollection $cars
//
//	 * @return Part
//	 */
//	public function setCars($cars): Part
//	{
//		$this->cars[] = $cars;
//		return $this;
//	}


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
     * @return Part
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
     * Set price.
     *
     * @param string $price
     *
     * @return Part
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price.
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set quantity.
     *
     * @param int $quantity
     *
     * @return Part
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity.
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

	/**
	 * @return string
	 */
	public function __toString(){
		// to show the name of the Category in the select
		return $this->name;
		// to show the id of the Category in the select
		// return $this->id;
	}

}
