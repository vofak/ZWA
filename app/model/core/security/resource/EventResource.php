<?php


namespace App\model\core\security\resource;


use App\model\core\security\SecurityMetadata;
use Nette\Database\Table\ActiveRow;
use Nette\Security\IResource;

/**
 * Class EventResource
 *
 * Resource representing an event entity for security resolvers
 *
 * @package App\model\core\security\resource
 */
class EventResource implements IResource
{
    private ActiveRow $eventEO;

    /**
     * EventResource constructor.
     *
     * @param ActiveRow $eventEO event entity object
     */
    public function __construct(ActiveRow $eventEO)
    {
        $this->eventEO = $eventEO;
    }

    /**
     * @return string resource id
     */
    function getResourceId(): string
    {
        return SecurityMetadata::eventResource;
    }

    /**
     * @return ActiveRow the resource event
     */
    public function getEventEO(): ActiveRow
    {
        return $this->eventEO;
    }
}