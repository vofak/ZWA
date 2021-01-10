<?php

declare(strict_types=1);


namespace App\model\facade\common;


use App\model\core\security\SecurityResolver;
use Exception;
use Nette\Security\IResource;
use Nette\Security\User;

/**
 * Class CommonFacade
 *
 * Abstract class for all facade classes - service layer
 *
 * @package App\model\facade\common
 */
abstract class CommonFacade
{
    private User $user;
    private SecurityResolver $securityResolver;

    /**
     * CommonFacade constructor.
     *
     * @param User $user
     * @param SecurityResolver $securityResolver
     */
    public function __construct(User $user, SecurityResolver $securityResolver)
    {
        $this->user = $user;
        $this->securityResolver = $securityResolver;
    }

    /**
     * @return User
     */
    protected function getUser(): User
    {
        return $this->user;
    }

    protected function isAllowed($resource, string $privilege): bool
    {
        return $this->securityResolver->isAllowed($resource, $privilege);
    }

    /**
     * @param string|IResource $resource
     * @param string $privilege
     * @throws Exception
     */
    protected function checkPermission($resource, string $privilege): void
    {
        $this->securityResolver->checkPermission($resource, $privilege);
    }

    /**
     * @param string|IResource $resource
     * @param string $privilege
     * @return string
     */
    protected function resolvePermissionLevel($resource, string $privilege): string
    {
        return $this->securityResolver->resolvePermissionLevel($resource, $privilege);
    }
}