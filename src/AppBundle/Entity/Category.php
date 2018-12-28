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

	private $parent_id;


	/**
	 * @return mixed
	 */
	public function getParentId()
	{
		return $this->parent_id;
	}

	/**
	 * @param mixed $parent_id
	 * @return Category
	 */
	public function setParentId($parent_id)
	{
		$this->parent_id = $parent_id;
		return $this;
	}


	/**
	 * Product in the category.
	 *
	 * @var ArrayCollection|Product[]
	 * @ORM\ManyToMany(targetEntity="Product", mappedBy="categories")
	 **/
	protected $products;

	/**
	 * The category parent.
	 *
	 * @var Category
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Category",inversedBy="children")
	 * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=true,onDelete="CASCADE")
	 **/
	protected $parent;

	/**
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Category",mappedBy="parent")
	 */
	protected $children;

	/**
	 * @var string
	 * @ORM\Column(name="path", type="text")
	 */
	private $path;

	public function __construct()
	{
		$this->products = new ArrayCollection();
		$this->children = new ArrayCollection();
	}


	/**
	 * @return mixed
	 */
	public function getChildren()
	{
		return $this->children;
	}

	/**
	 * @param mixed $children
	 * @return Category
	 * @return Category
	 */
	public function setChildren($children)
	{
		$this->children = $children;
		return $this;
	}

	public function addChildren(Category $children)
	{
		$this->children[] = $children;
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
		$this->name = htmlspecialchars($name);
		$this->setPath();
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
		$this->setPath();
		return $this;
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
	 * @return ArrayCollection|Product[]
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
	/**
	 * @return string
	 */
	public function getPath(): string
	{
		return $this->path ?? '';
	}
	/**
	 * @return Category
	 */
	public function setPath(): Category
	{
		$path = $this->path;
		$parentPath = null === $this->parent ? '' : $this->parent->getPath();
		$pathShouldBe = $parentPath . '/' . $this->name;
		if ($path !== $pathShouldBe) {
			// update own path
			$this->path = $pathShouldBe;
			// recursively update the paths of all children
			foreach ($this->children as $child) {
				$child->setPath();
			}
		}
		return $this;
	}
	public function getNameTree(): string
	{
		$n = substr_count($this->path, '/');
		return str_repeat('..', ($n) * 5) . '|____' . $this->name;
	}

	public function getOptionPath(): string
	{
		return $this->getPath();
	}
}
