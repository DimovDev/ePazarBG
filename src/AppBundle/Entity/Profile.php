<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Profile
 *
 * @ORM\Table(name="profiles")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProfileRepository")
 */
class Profile
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
     * @ORM\Column(name="location", type="string", length=255)
     */
    private $location;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;

	/**
	 *@var User
	 *
	 * @ORM\OneToOne(targetEntity="AppBundle\Entity\User",mappedBy="profiles")
	 * @ORM\JoinColumn(name="users_id", referencedColumnName="id")
	 */
	private $users;

	/**
	 * @return User
	 */
	public function getUsers(): User
	{
		return $this->users;
	}

	/**
	 * @param User $users
	 * @return void
	 */
	public function setUsers(User $users): void
	{
		$this->users = $users;

	}

	/**
	 *
	 */



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
     * Set location.
     *
     * @param string $location
     *
     * @return Profile
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
     * Set image.
     *
     * @param string $image
     *
     * @return Profile
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
}
