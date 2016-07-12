<?php
namespace Fei\Service\Logger\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Index;
use Doctrine\ORM\Mapping\Table;
use Fei\Entity\AbstractEntity;


/**
 * Class Context
 *
 * @Entity
 * @Table(name="contexts", indexes={@Index(name="idx_contexts_keys", columns={"key"})})
 */
class Context extends AbstractEntity
{
	/**
	 * @Id
	 * @GeneratedValue(strategy="AUTO")
	 * @Column(type="integer")
	 */
	protected $id;

	/**
	 * @Column(type="integer")
	 */
	protected $notification_id;

	/**
	 * @ManyToOne(targetEntity="Notification", inversedBy="contexts")
	 * @JoinColumn(name="notification_id", referencedColumnName="id")
	 */
	protected $notification;

	/**
	 * @Column(type="string")
	 */
	protected $key;

	/**
	 * @Column(type="string")
	 */
	protected $value;


	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param mixed $id
	 *
	 * @return Context
	 */
	public function setId($id)
	{
		$this->id = $id;

		return $this;
	}


	/**
	 * @return mixed
	 */
	public function getNotificationId()
	{
		return $this->notification_id;
	}

	/**
	 * @param mixed $notification_id
	 *
	 * @return Notification
	 */
	public function setNotificationId($notification_id)
	{
		$this->notification_id = $notification_id;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getKey()
	{
		return $this->key;
	}

	/**
	 * @param mixed $key
	 *
	 * @return Notification
	 */
	public function setKey($key)
	{
		$this->key= $key;

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getValue()
	{
		return $this->value;
	}

	/**
	 * @param mixed $namespace
	 *
	 * @return Notification
	 */
	public function setValue($value)
	{
		$this->value = $value;

		return $this;
	}

}
