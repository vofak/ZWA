<?php


namespace App\model\common;

/**
 * Class EventState
 *
 * Enumeration of states that an event can be in
 *
 * @package App\model\common
 */
class EventState
{
    const planned = "planned";
    const running = "running";
    const finished = "finished";
    const canceled = "canceled";
}