<?php

namespace ContainerLqp0pSr;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/*
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getConsole_Command_CachePoolClearService extends phpDocumentor_KernelProdContainer
{
    /*
     * Gets the private 'console.command.cache_pool_clear' shared service.
     *
     * @return \Symfony\Bundle\FrameworkBundle\Command\CachePoolClearCommand
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 6).'/symfony/console/Command/Command.php';
        include_once \dirname(__DIR__, 6).'/symfony/framework-bundle/Command/CachePoolClearCommand.php';

        $container->privates['console.command.cache_pool_clear'] = $instance = new \Symfony\Bundle\FrameworkBundle\Command\CachePoolClearCommand(($container->services['cache.global_clearer'] ?? $container->load('getCache_GlobalClearerService')));

        $instance->setName('cache:pool:clear');

        return $instance;
    }
}
