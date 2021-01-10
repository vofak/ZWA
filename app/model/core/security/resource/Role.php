<?php


namespace App\model\core\security\resource;


use Nette\Security\IRole;
use Nette\Security\User;

/**
 * Class Role
 *
 * A class representing a user role implementing IRole interface
 *
 * @package App\model\core\security\resource
 */
class Role implements IRole
{
    private User $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    /**
     * @return string the user role name
     */
    function getRoleId(): string
    {
        $roleId = $this->user->getRoles()[0];
        return $roleId;
    }

    /**
     * @return User the user
     */
    public function getUser(): User
    {
        return $this->user;
    }

}