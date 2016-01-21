<?php
// Filename: /module/Application/src/Application/Model/User.php
namespace Application\Model;

class User
{
    /**
     *
     * @var int
     */
    public $id;

    /**
     *
     * @var string
     */
    public $username;

    /**
     *
     * @var string
     */
    public $password;

    /**
     *
     * @var string
     */
    public $email;
    public $phone;
    public $note;

    /**
     *
     * @var string
     */
    public $avatar;

    /**
     *
     * @var int
     */
    public $role_id;

    /**
     *
     * @var int
     */
    public $block;

    /**
     *
     * @var string
     */
    public $create_date;

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    public function getUsername()
    {
        return $this->username;
    }
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }
    public function getAvatar()
    {
        return $this->avatar;
    }
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
        return $this;
    }
    public function getRoleId()
    {
        return $this->role_id;
    }
    public function setRoleId($role_id)
    {
        $this->role_id = $role_id;
        return $this;
    }
    public function getBlock()
    {
        return $this->block;
    }
    public function setBlock($block)
    {
        $this->block = $block;
        return $this;
    }
    public function getCreateDate()
    {
        return $this->create_date;
    }
    public function setCreateDate($create_date)
    {
        $this->create_date = $create_date;
        return $this;
    }

    public function __construct($id, $username, $password, $role_id)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->role_id = $role_id;
    }
}