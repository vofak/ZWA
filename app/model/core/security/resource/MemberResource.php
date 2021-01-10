<?php


namespace App\model\core\security\resource;


use App\model\core\security\SecurityMetadata;
use Nette\Database\Table\ActiveRow;
use Nette\Security\IResource;

/**
 * Class MemberResource
 *
 * Resource representing a member entity for security resolvers
 *
 * @package App\model\core\security\resource
 */
class MemberResource implements IResource
{
    /** @var array|ActiveRow */
    private $memberEO;

    /**
     * MemberResource constructor.
     * @param ActiveRow|array $memberEO
     */
    public function __construct($memberEO)
    {
        $this->memberEO = $memberEO;
    }

    /**
     * @return string resource id
     */
    function getResourceId(): string
    {
        return SecurityMetadata::memberResource;
    }

    /**
     * @return ActiveRow|array the resource member
     */
    public function getMemberEO()
    {
        return $this->memberEO;
    }

}