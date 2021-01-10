<?php


namespace App\model\core\security;


use App\model\common\EventState;
use App\model\common\UserRole;
use App\model\core\security\resource\EventResource;
use App\model\core\security\resource\MemberResource;
use App\model\core\security\resource\Role;
use App\model\dal\metadata\EventMetadata;
use App\model\dal\metadata\MemberMetadata;
use Nette\Security\Permission;

/**
 * Class AuthorizationFactory
 *
 * Factory class creating Nette's Permission component
 *
 * @package App\model\core\security
 */
class AuthorizationFactory
{
    /**
     * @return Permission permission
     */
    //todo custom IAuthorizator. Permission sucks
    public static function create(): Permission
    {
        $acl = new Permission();

        # CALLBACKS
        $coreTeamEditAssertion = function (Permission $acl, string $role, string $resource, string $privilege): bool
        {
            /** @var EventResource $resource */
            $resource = $acl->getQueriedResource();
            $eventEO = $resource->getEventEO();

            /** @var Role $role */
            $role = $acl->getQueriedRole();
            $user = $role->getUser();

            if ($role->getRoleId() == UserRole::admin) {
                return true;
            }
            if ($eventEO[EventMetadata::$mainOrganiserId] != $user->getId()) {
                return false;
            }
            if ($eventEO[EventMetadata::$state] != EventState::planned) {
                return false;
            }
            return true;
        };

        $memberEditAssertion = function (Permission $acl, string $role, string $resource, string $privilege): bool
        {
            /** @var MemberResource $resource */
            $resource = $acl->getQueriedResource();
            $memberEO = $resource->getMemberEO();

            /** @var Role $role */
            $role = $acl->getQueriedRole();
            $user = $role->getUser();

            if ($role->getRoleId() == UserRole::admin) {
                return true;
            }
            if ($memberEO[MemberMetadata::$memberId] == $user->getId()) {
                return true;
            }
            return false;
        };

        # RESOURCES
        $acl->addResource(SecurityMetadata::memberResource);
        $acl->addResource(SecurityMetadata::eventResource);
        $acl->addResource(SecurityMetadata::coreTeamPositionResource);
        $acl->addResource(SecurityMetadata::electionResource);
        $acl->addResource(SecurityMetadata::boardResource);

        # ROLES
        $acl->addRole(SecurityMetadata::$adminRole);
        $acl->addRole(SecurityMetadata::$memberRole);
        $acl->addRole(SecurityMetadata::$guestRole);

        #ADMIN
        $acl->allow(SecurityMetadata::$adminRole, Permission::ALL, Permission::ALL);

        #MEMBER
        $acl->allow(SecurityMetadata::$memberRole, SecurityMetadata::memberResource, SecurityMetadata::$viewAction);
        $acl->allow(SecurityMetadata::$memberRole, SecurityMetadata::memberResource, SecurityMetadata::$editAction, $memberEditAssertion);
        $acl->allow(SecurityMetadata::$memberRole, SecurityMetadata::eventResource, SecurityMetadata::$viewAction);
        $acl->allow(SecurityMetadata::$memberRole, SecurityMetadata::eventResource, SecurityMetadata::$editCoreTeamAction, $coreTeamEditAssertion);
        $acl->allow(SecurityMetadata::$memberRole, SecurityMetadata::coreTeamPositionResource, SecurityMetadata::$viewAction);
        $acl->allow(SecurityMetadata::$memberRole, SecurityMetadata::electionResource, SecurityMetadata::$viewAction);
        $acl->allow(SecurityMetadata::$memberRole, SecurityMetadata::boardResource, SecurityMetadata::$viewAction);

        #GUEST
        $acl->allow(SecurityMetadata::$memberRole, SecurityMetadata::memberResource, SecurityMetadata::$viewAction);
        $acl->allow(SecurityMetadata::$memberRole, SecurityMetadata::eventResource, SecurityMetadata::$viewAction);
        $acl->allow(SecurityMetadata::$memberRole, SecurityMetadata::coreTeamPositionResource, SecurityMetadata::$viewAction);
        $acl->allow(SecurityMetadata::$memberRole, SecurityMetadata::electionResource, SecurityMetadata::$viewAction);
        $acl->allow(SecurityMetadata::$memberRole, SecurityMetadata::boardResource, SecurityMetadata::$viewAction);

        return $acl;
    }
}