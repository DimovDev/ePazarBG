<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Message
 *
 * @ORM\Table(name="messages")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MessageRepository")
 */
class Message
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
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timestamp", type="datetime")
     */
    private $timestamp;

	/**
	 * @var User
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User",inversedBy="sentMessages")
	 *  @ORM\JoinColumn(name="sender_id", referencedColumnName="id")
	 */
    private $sender;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="receivedMessages")
     * @ORM\JoinColumn(name="recipient_id", referencedColumnName="id")
     */
    private $recipient;

    public function __construct()
    {
    	$this->setTimestamp(new \DateTime('now'));
    }

	/**
	 * @return null|User
	 */
	public function getSender():? User
	{
		return $this->sender;
	}

	/**
	 * @param User $sender
	 * @return Message
	 */
	public function setSender(User $sender)
	{
		$this->sender = $sender;
		$sender->addSentMessage($this);
		return $this;
	}

	/**
	 * @return null| User
	 */
	public function getRecipient():? User
	{
		return $this->recipient;
	}

	/**
	 * @param User $recipient
	 * @return Message
	 */
	public function setRecipient(User $recipient)
	{
		$this->recipient = $recipient;
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
     * @return Message
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
     * Set content.
     *
     * @param string $content
     *
     * @return Message
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
     * Set timestamp.
     *
     * @param \DateTime $timestamp
     *
     * @return Message
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * Get timestamp.
     *
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }
}
