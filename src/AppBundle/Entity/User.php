<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * UserType
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User implements UserInterface
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
	 * @ORM\Column(name="email", type="string", length=255, unique=true)
	 */
	private $email;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="password", type="string", length=255)
	 */
	private $password;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="fullName", type="string", length=255, unique=true)
	 */
	private $fullName;

	/**
	 * @var ArrayCollection
	 *
	 * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Role",inversedBy="users")
	 */
	private $roles;

	/**
	 * @var ORM\OneToOne(targetEntity="AppBundle\Entity\Profile",inversedBy="users")
	 */
	private $profiles;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="image", type="string", length=255)
	 */
	private $image;

	/**
	 * @return string
	 */
	public function getImage():? string
	{
		return $this->image;
	}

	/**
	 * @param string $image
	 * @return User
	 */
	public function setImage(? string $image)
	{if(!$image){
		$this->image='';
	}else {
		$this->image = $image  ;
	}
		return $this;
	}

	/**
	 * @return ORM\OneToOne
	 */
	public function getProfiles(): ORM\OneToOne
	{
		return $this->profiles;
	}

	/**
	 * @param ORM\OneToOne $profiles
	 * @return User
	 */
	public function setProfiles(ORM\OneToOne $profiles)
	{
		$this->profiles = $profiles;
		return $this;

	}
	/**
	 * @var ArrayCollection
	 *
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\Product",mappedBy="author")
	 */
	private $products;

	/**
	 * @return ArrayCollection
	 */
	public function getProducts(): ArrayCollection
	{
		return $this->products;
	}

	/**
	 * @param Product $product
	 * @return User
	 */
	public function setProducts(Product $product): User
	{
		$this->products[] = $product;
		return $this;
	}

	/**
	 * User constructor.
	 */
	public function __construct()
	{
		$this->roles = new ArrayCollection();
		$this->products = new ArrayCollection();
	}

	/**
	 * Returns the roles granted to the users.
	 *
	 *     public function getRoles()
	 *     {
	 *         return array('ROLE_USER');
	 *     }
	 *
	 * Alternatively, the roles might be stored on a ``roles`` property,
	 * and populated in any number of different ways when the users object
	 * is created.
	 *
	 * @return (Role|string)[] The users roles
	 */
	public function getRoles(): array
	{
		$stringRoles = [];
		foreach ($this->roles as $role) {
			/**
			 * @var $role Role
			 */
			$stringRoles[] = $role->getRole();
		}
		return $stringRoles;
	}
	public function editRoles(): array
	{
		$stringRoles = [];
		foreach ($this->roles as $role) {
			/**
			 * @var $role Role
			 */
			$stringRoles[] = $role->setRole();
		}
		return $stringRoles;
	}



	/**
	 * @param Role $role
	 * @return User
	 */
	public function addRole(Role $role)
	{
		$this->roles[] = $role;

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
	 * Set email.
	 *
	 * @param string $email
	 *
	 * @return User
	 */
	public function setEmail($email)
	{
		$this->email = $email;

		return $this;
	}

	/**
	 * Get email.
	 *
	 * @return string
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * Set password.
	 *
	 * @param string $password
	 *
	 * @return User
	 */
	public function setPassword($password)
	{
		$this->password = $password;

		return $this;
	}

	/**
	 * Get password.
	 *
	 * @return string
	 */
	public function getPassword()
	{
		return $this->password;
	}

	/**
	 * Set fullName.
	 *
	 * @param string $fullName
	 *
	 * @return User
	 */
	public function setFullName($fullName)
	{
		$this->fullName = $fullName;

		return $this;
	}

	/**
	 * Get fullName.
	 *
	 * @return string
	 */
	public function getFullName()
	{
		return $this->fullName;
	}

	/**
	 * @param Role|null $roles
	 * @return User
	 */
	public function setRoles(Role $roles=null)
	{
		$this->roles= $roles;
		return $this;
	}

	/**
	 * Returns the salt that was originally used to encode the password.
	 *
	 * This can return null if the password was not encoded using a salt.
	 *
	 * @return string|null The salt
	 */
	public function getSalt()
	{
		// TODO: Implement getSalt() method.
	}

	/**
	 * Returns the username used to authenticate the user.
	 *
	 * @return string The username
	 */
	public function getUsername()
	{
		// TODO: Implement getUsername() method.
	}

	/**
	 * Removes sensitive data from the user.
	 *
	 * This is important if, at any given point, sensitive information like
	 * the plain-text password is stored on this object.
	 */
	public function eraseCredentials()
	{
		// TODO: Implement eraseCredentials() method.
	}

	/**
	 * @return ArrayCollection|string
	 */
	public function __toString() {
		return $this->email;

	}


	/**
	 * @return bool
	 */
	public function isAdmin()
	{
		return in_array('ROLE_ADMIN',$this->getRoles());
	}


}
