<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sale
 *
 * @ORM\Table(name="sales")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SaleRepository")
 */
class Sale
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
     * @var float
     *
     * @ORM\Column(name="Discount", type="float")
     */
    private $discount;
	/**
	 * @ORM\OneToOne(targetEntity="AppBundle\Entity\Car")
	 * @ORM\JoinColumn(name="car_id",referencedColumnName="id")
	 */
    private $car;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Customer",inversedBy="sales")
     * @ORM\JoinColumn(name="customer_id",referencedColumnName="id")
     */
    private $customer;

	/**
	 * @return mixed
	 */
	public function getCar()
	{
		return $this->car;
	}

	/**
	 * @param mixed $car
	 *
	 * @return Sale
	 */
	public function setCar($car): Sale
	{
		$this->car = $car;
		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getCustomer()
	{
		return $this->customer;
	}

	/**
	 * @param mixed $customer
	 * @return Sale
	 */
	public function setCustomer($customer): Sale
	{
		$this->customer = $customer;
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
     * Set discount.
     *
     * @param float $discount
     *
     * @return Sale
     */
    public function setDiscount($discount): Sale
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * Get discount.
     *
     * @return float
     */
    public function getDiscount()
    {
        return $this->discount;
    }
	public function __toString()
	{
		$name = $this->car;
		$customer = $this->customer;
		return "$name $customer";
	}
}
