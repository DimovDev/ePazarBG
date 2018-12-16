<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoryRepository")
 */
class Category
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
	 * Product in the category.
	 *
	 * @var Product[]
	 * @ORM\ManyToMany(targetEntity="Product", mappedBy="categories")
	 **/
	protected $products;

	/**
	 * The category parent.
	 *
	 * @var Category
	 * @ORM\ManyToOne(targetEntity="Category")
	 * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=true)
	 **/
	protected $parent;

	public function __construct()
	{
		$this->products = new ArrayCollection();
	}

	public function __toString()
	{
		return $this->getName();
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
     * @return Category
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
	 * Set the parent category.
	 *
	 * @param Category $parent
	 */
	public function setParent($parent)
	{
		$this->parent = $parent;
	}

	/**
	 * Get the parent category.
	 *
	 * @return Category
	 */
	public function getParent()
	{
		return $this->parent;
	}

	/**
	 * Return all product associated to the category.
	 *
	 * @return Product[]
	 */
	public function getProducts()
	{
		return $this->products;
	}

	/**
	 * Set all products in the category.
	 *
	 * @param Product[] $products
	 */
	public function setProducts($products)
	{
		$this->products->clear();
		$this->products = new ArrayCollection($products);
	}

	/**
	 * Add a product in the category.
	 *
	 * @param $product Product The product to associate
	 */
	public function addProduct($product)
	{
		if ($this->products->contains($product)) {
			return;
		}

		$this->products->add($product);
		$product->addCategory($this);
	}

	/**
	 * @param Product $product
	 */
	public function removeProduct($product)
	{
		if (!$this->products->contains($product)) {
			return;
		}

		$this->products->removeElement($product);
		$product->removeCategory($this);
	}
}
