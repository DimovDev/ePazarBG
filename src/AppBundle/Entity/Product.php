<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Product
 *@ParamConverter("product", class="AppBundle\Entity\Product", options={"mapping": {"product": "id"}})
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductRepository")
 */
class Product
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
	 * @ORM\Column(name="title", type="string", length=255)
	 */
	private $title;

	/**
	 * List of categories where the products is
	 * (Owning side).
	 *
	 * @var Category[]
	 * @ORM\ManyToMany(targetEntity="Category", inversedBy="products")
	 * @ORM\JoinTable(name="product_category")
	 */
	private $categories;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="description", type="text")
	 */
	private $description;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="image", type="string", nullable=false)
	 */
	private $image;

	/**
	 * The price of the product.
	 *
	 * @var float
	 * @ORM\Column(type="float")
	 */
	private $price = 0.0;

	/**
	 * @return float
	 */
	public function getPrice(): float
	{
		return $this->price;
	}

	/**
	 * @param float $price
	 * @return void
	 */
	public function setPrice(float $price)
	{
		$this->price = $price;

	}

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="dateAdded", type="datetime")
	 */
	private $dateAdded;

	/**
	 * @var int
	 *
	 * @ORM\Column(name="authorId", type="integer")
	 */
	private $authorId;


	/**
	 * @var string
	 *
	 * @ORM\Column(name="location", type="string", length=255)
	 */
	private $location;

	/**
	 * @var int
	 *
	 * @ORM\Column(name="phone", type="integer")
	 */
	private $phone;

	/**
	 * @var int
	 *
	 * @ORM\Column(name="viewCount", type="integer")
	 */
	private $viewCount;

	/**
	 * @var User
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User",inversedBy="products")
	 * @ORM\JoinColumn(name="authorId",referencedColumnName="id",onDelete="CASCADE")
	 */
	private $author;
	/**
	 * @var ArrayCollection|Review[]
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Review",mappedBy="product",cascade={"remove"})
     *
	 */
	private $reviews;

	public function __construct()
	{
		$this->dateAdded = new \DateTime('now');
		$this->categories = new ArrayCollection();
		$this->reviews=new ArrayCollection();
	}

	/**
	 * @return Review[]|ArrayCollection
	 */
	public function getReviews()
	{
		return $this->reviews;
	}

	/**
	 * @param Review|null $review
	 * @return Product
	 */
	public function addReview(Review $review=null)
	{
		$this->reviews[] = $review;
		return $this;
	}

	/**
	 * @return integer|null
	 */
	public function getViewCount(): ?int
	{
		return $this->viewCount;
	}

	/**
	 * @param integer $viewCount
	 *
	 */
	public function setViewCount($viewCount): void
	{
		$this->viewCount = $viewCount;

	}

	/**
	 * @return User|null
	 */
	public function getAuthor(): ? User
	{
		return $this->author;
	}

	/**
	 *
	 *
	 * @param \AppBundle\Entity\User $author
	 * @return Product
	 */
	public function setAuthor(User $author = null): Product
	{
		$this->author = $author;
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
	 * Set title.
	 *
	 * @param string $title
	 *
	 * @return Product
	 */
	public function setTitle($title)
	{
		$this->title = $title;

		return $this;
	}

	/**
	 * Get title.
	 *
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}


	/**
	 * Set description.
	 *
	 * @param string $description
	 *
	 * @return Product
	 */
	public function setDescription($description)
	{
		$this->description = $description;

		return $this;
	}

	/**
	 * Get description.
	 *
	 * @return string
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * Set image.
	 *
	 * @param string $image
	 *
	 * @return Product
	 */
	public function setImage($image)
	{
		$this->image = $image;

		return $this;
	}

	/**
	 * Get image.
	 *
	 * @return string
	 */
	public function getImage()
	{
		return $this->image;
	}

	/**
	 * Set dateAdded.
	 *
	 * @param \DateTime $dateAdded
	 *
	 * @return Product
	 */
	public function setDateAdded($dateAdded)
	{
		$this->dateAdded = $dateAdded;

		return $this;
	}

	/**
	 * Get dateAdded.
	 *
	 * @return \DateTime
	 */
	public function getDateAdded()
	{
		return $this->dateAdded;
	}

	/**
	 * Set authorId.
	 *
	 * @param int $authorId
	 *
	 * @return Product
	 */
	public function setAuthorId($authorId)
	{
		$this->authorId = $authorId;

		return $this;
	}

	/**
	 * Get authorId.
	 *
	 * @return int
	 */
	public function getAuthorId()
	{
		return $this->authorId;
	}

	/**
	 * Set location.
	 *
	 * @param string $location
	 *
	 * @return Product
	 */
	public function setLocation($location)
	{
		$this->location = $location;

		return $this;
	}

	/**
	 * Get location.
	 *
	 * @return string
	 */
	public function getLocation()
	{
		return $this->location;
	}

	/**
	 * Set phone.
	 *
	 * @param int $phone
	 *
	 * @return Product
	 */
	public function setPhone($phone)
	{
		$this->phone = $phone;

		return $this;
	}

	/**
	 * Get phone.
	 *
	 * @return int
	 */
	public function getPhone()
	{
		return $this->phone;
	}

	/**
	 * Get all associated categories.
	 *
	 * @return Category[]
	 */
	public function getCategories()
	{
		return $this->categories;
	}

	/**
	 * Set all categories of the product.
	 *
	 * @param Category[] $categories
	 */
	public function setCategories($categories)
	{
		// This is the owning side, we have to call remove and add to have change in the category side too.
		foreach ($this->getCategories() as $category) {
			$this->removeCategory($category);
		}
		foreach ($categories as $category) {
			$this->addCategory($category);
		}
	}

	/**
	 * Add a category in the product association.
	 * (Owning side).
	 *
	 * @param $category Category the category to associate
	 */
	public function addCategory($category)
	{
		if ($this->categories->contains($category)) {
			return;
		}

		$this->categories->add($category);
		$category->addProduct($this);
	}

	/**
	 * Remove a category in the product association.
	 * (Owning side).
	 *
	 * @param $category Category the category to associate
	 */
	public function removeCategory($category)
	{
		if (!$this->categories->contains($category)) {
			return;
		}

		$this->categories->removeElement($category);
		$category->removeProduct($this);
	}

	/**
	 * {@inheritdoc}
	 */
	public function __toString()
	{
		return $this->getTitle();
	}

	public function getNameTree(): string
	{
		$n = substr_count($this->path, '/');
		return str_repeat('..', ($n) * 5) . '|____' . $this->name;
	}

}
