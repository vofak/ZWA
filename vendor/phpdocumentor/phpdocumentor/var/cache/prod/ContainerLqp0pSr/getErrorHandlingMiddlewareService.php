<?php

namespace ContainerLqp0pSr;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/*
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getErrorHandlingMiddlewareService extends phpDocumentor_KernelProdContainer
{
    /*
     * Gets the private 'phpDocumentor\Parser\Middleware\ErrorHandlingMiddleware' shared autowired service.
     *
     * @return \phpDocumentor\Parser\Middleware\ErrorHandlingMiddleware
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 5).'/reflection/src/phpDocumentor/Reflection/Middleware/Middleware.php';
        include_once \dirname(__DIR__, 4).'/src/phpDocumentor/Parser/Middleware/ErrorHandlingMiddleware.php';

        return $container->privates['phpDocumentor\\Parser\\Middleware\\ErrorHandlingMiddleware'] = new \phpDocumentor\Parser\Middleware\ErrorHandlingMiddleware(($container->privates['monolog.logger'] ?? $container->load('getMonolog_LoggerService')));
    }
}
