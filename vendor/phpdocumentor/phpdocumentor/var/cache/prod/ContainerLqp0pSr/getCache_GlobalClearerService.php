<?php

namespace ContainerLqp0pSr;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/*
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getCache_GlobalClearerService extends phpDocumentor_KernelProdContainer
{
    /*
     * Gets the public 'cache.global_clearer' shared service.
     *
     * @return \Symfony\Component\HttpKernel\CacheClearer\Psr6CacheClearer
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 6).'/symfony/http-kernel/CacheClearer/CacheClearerInterface.php';
        include_once \dirname(__DIR__, 6).'/symfony/http-kernel/CacheClearer/Psr6CacheClearer.php';
        include_once \dirname(__DIR__, 6).'/psr/cache/src/CacheItemPoolInterface.php';
        include_once \dirname(__DIR__, 6).'/symfony/cache/Adapter/AdapterInterface.php';
        include_once \dirname(__DIR__, 6).'/symfony/contracts/Cache/CacheInterface.php';
        include_once \dirname(__DIR__, 6).'/psr/log/Psr/Log/LoggerAwareInterface.php';
        include_once \dirname(__DIR__, 6).'/symfony/cache/ResettableInterface.php';
        include_once \dirname(__DIR__, 6).'/psr/log/Psr/Log/LoggerAwareTrait.php';
        include_once \dirname(__DIR__, 6).'/symfony/cache/Traits/AbstractAdapterTrait.php';
        include_once \dirname(__DIR__, 6).'/symfony/contracts/Cache/CacheTrait.php';
        include_once \dirname(__DIR__, 6).'/symfony/cache/Traits/ContractsTrait.php';
        include_once \dirname(__DIR__, 6).'/symfony/cache/Adapter/AbstractAdapter.php';
        include_once \dirname(__DIR__, 6).'/symfony/cache/PruneableInterface.php';
        include_once \dirname(__DIR__, 6).'/symfony/cache/Traits/FilesystemCommonTrait.php';
        include_once \dirname(__DIR__, 6).'/symfony/cache/Traits/FilesystemTrait.php';
        include_once \dirname(__DIR__, 4).'/src/phpDocumentor/Parser/Cache/FilesystemAdapter.php';

        return $container->services['cache.global_clearer'] = new \Symfony\Component\HttpKernel\CacheClearer\Psr6CacheClearer(['cache.app' => ($container->services['cache.app'] ?? $container->load('getCache_AppService')), 'cache.system' => ($container->services['cache.system'] ?? $container->load('getCache_SystemService')), 'files' => ($container->privates['files'] ?? ($container->privates['files'] = new \phpDocumentor\Parser\Cache\FilesystemAdapter('9tJQq9ILsv'))), 'descriptors' => ($container->privates['descriptors'] ?? ($container->privates['descriptors'] = new \phpDocumentor\Parser\Cache\FilesystemAdapter('RR6Hghay88')))]);
    }
}
