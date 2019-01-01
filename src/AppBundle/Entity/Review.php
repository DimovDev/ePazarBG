<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * ReviewType
 *
 * @ORM\Table(name="reviews")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ReviewRepository")
 */
class Review
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
     * @ORM\Column(name="content", type="string", length=255)
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateAdded", type="datetime")
     */
    private $dateAdded;

    /**
     * @var int
     *
     * @ORM\Column(name="rating", type="integer")
     */
    private $rating;

	/**
	 *
	 * @var Product
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Product",inversedBy="reviews")
	 *  @ORM\JoinColumn(name="product_id", referencedColumnName="id")
	 */
    private $product;

	/**
	 * @var User
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User",inversedBy="reviews")
	 */
    private $author;

    public function __construct()
    {
    	$this->dateAdded=new \DateTime('now');


    }

	/**
	 * @return Product
	 */
	public function getProduct()
	{
		return $this->product;
	}

	/**
	 * @param Product $product
	 * @return Review
	 */
	public function setProduct(Product $product=null): Review
	{
		$this->product = $product;
		return $this;
	}

	/**
	 * @return User
	 */
	public function getAuthor()
	{
		return $this->author;
	}

	/**
	 * @param User $author
	 * @return Review
	 */
	public function setAuthor(User $author=null): Review
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
     * Set content.
     *
     * @param string $content
     *
     * @return Review
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set dateAdded.
     *
     * @param \DateTime $dateAdded
     *
     * @return Review
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
     * Set rating.
     *
     * @param int $rating
     *
     * @return Review
     */
    public function setRating($rating): Review
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get rating.
     *
     * @return int
     */
    public function getRating()
    {
        return $this->rating;
    }
}
