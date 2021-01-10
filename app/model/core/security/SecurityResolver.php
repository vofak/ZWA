<?php


namespace App\model\core\security;


use App\model\common\PermissionLevel;
use App\model\core\security\resource\Role;
use Exception;
use Nette\Security\IResource;
use Nette\Security\Permission;
use Nette\Security\User;

/**
 * Class SecurityResolver
 *
 * Resolves permission for actions on resources by users
 *
 * @package App\model\core\security
 */
class SecurityResolver
{
    private User $user;
    private Permission $acl;

    /**
     * SecurityResolver constructor.
     *
     * @param User $user
     * @param Permission $acl
     */
    public function __construct(User $user, Permission $acl)
    {
        $this->user = $user;
        $this->acl = $acl;
    }

    /**
     * Checks permission. Throws exception when the permission is not granted
     *
     * @param string|IResource $resource resource to be accessed
     * @param string $privilege privilege
     * @throws Exception
     */
    public function checkPermission($resource, string $privilege): void
    {
        if (!$this->isAllowed($resource, $privilege)) {
            throw new Exception("Unauthorized access", 403);
        }
    }

    /**
     * @param string|IResource $resource resource to be accessed
     * @param string $privilege privilege
     * @return bool whether the privilege is granted
     */
    public function isAllowed($resource, string $privilege): bool
    {
        $role = new Role($this->user);

        return $this->acl->isAllowed($role, $resource, $privilege);
    }

    /**
     * @param string|IResource $resource resource to be accessed
     * @param string $privilege privilege
     * @return string permission level
     */
    public function resolvePermissionLevel($resource, string $privilege): string
    {
        $allowed = $this->isAllowed($resource, $privilege);

        //todo also the disabled permission level (e.g. the button will be visible but it will be disabled)
        return $allowed ? PermissionLevel::enabled : PermissionLevel::disabled;
    }
}