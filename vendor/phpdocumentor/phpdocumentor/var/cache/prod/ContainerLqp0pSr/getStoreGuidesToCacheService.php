<?php

namespace ContainerLqp0pSr;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/*
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getStoreGuidesToCacheService extends phpDocumentor_KernelProdContainer
{
    /*
     * Gets the private 'phpDocumentor\Pipeline\Stage\Cache\StoreGuidesToCache' shared autowired service.
     *
     * @return \phpDocumentor\Pipeline\Stage\Cache\StoreGuidesToCache
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/src/phpDocumentor/Pipeline/Stage/Cache/StoreGuidesToCache.php';

        return $container->privates['phpDocumentor\\Pipeline\\Stage\\Cache\\StoreGuidesToCache'] = new \phpDocumentor\Pipeline\Stage\Cache\StoreGuidesToCache(($container->services['tactician.commandbus.default'] ?? $container->load('getTactician_Commandbus_DefaultService')), ($container->privates['monolog.logger'] ?? $container->load('getMonolog_LoggerService')));
    }
}
