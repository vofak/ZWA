<?php

namespace ContainerLqp0pSr;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/*
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getLoadGuidesFromCacheService extends phpDocumentor_KernelProdContainer
{
    /*
     * Gets the private 'phpDocumentor\Pipeline\Stage\Cache\LoadGuidesFromCache' shared autowired service.
     *
     * @return \phpDocumentor\Pipeline\Stage\Cache\LoadGuidesFromCache
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/src/phpDocumentor/Pipeline/Stage/Cache/LoadGuidesFromCache.php';

        return $container->privates['phpDocumentor\\Pipeline\\Stage\\Cache\\LoadGuidesFromCache'] = new \phpDocumentor\Pipeline\Stage\Cache\LoadGuidesFromCache(($container->services['tactician.commandbus.default'] ?? $container->load('getTactician_Commandbus_DefaultService')), ($container->privates['monolog.logger'] ?? $container->load('getMonolog_LoggerService')));
    }
}
