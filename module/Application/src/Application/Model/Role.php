<?php
// Filename: /module/Application/src/Application/Model/Role.php
namespace Application\Model;

class Role implements RoleInterface
{
	/**
	 *
	 * @var int
	 */
	protected $id;

	/**
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * {@inheritDoc}
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 *
	 * @param int $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 *
	 * @param string $title
	 */
	public function setName($Name)
	{
		$this->name = name;
	}
}