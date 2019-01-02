<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Role
 *
 * @ORM\Table(name="roles")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RoleRepository")
 */
class Role
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

	/**
	 * @var ArrayCollection
	 *
	 * @ORM\ManyToMany(targetEntity="AppBundle\Entity\User",mappedBy="roles")
	 */
    private $users;

public function __construct()
{
	$this->users=new ArrayCollection();
}

	/**
	 *@return Collection
	 */
	public function getUsers():Collection
	{
		return $this->users;
	}

	/**
	 * @param ArrayCollection $users
	 *
	 */
	public function setUsers(ArrayCollection $users): void
	{
		$this->users = $users;

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
     * @return Role
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

    public function getRole(): string
    {
    	return $this->getName();
    }

	public function setRole(): string
	{
		return $this->getName();
	}
	/**
	 * @param User $user
	 * @return Role
	 */
	public function addUser(User $user): Role
	{
		$this->users[] = $user;
		$user->addRole($this);
		return $this;
	}
}
