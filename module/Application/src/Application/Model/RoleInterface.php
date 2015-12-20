<?php
// Filename: /module/Application/src/Application/Model/RoleInterface.php
namespace Application\Model;

interface RoleInterface
{
	/**
	 * Will return the ID of the chat post
	 *
	 * @return int
	 */
	public function getId();

	/**
	 * Will return the TITLE of the chat post
	 *
	 * @return string
	 */
	public function getName();
}