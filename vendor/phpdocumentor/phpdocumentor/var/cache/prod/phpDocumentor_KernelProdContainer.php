<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerLqp0pSr\phpDocumentor_KernelProdContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerLqp0pSr/phpDocumentor_KernelProdContainer.php') {
    touch(__DIR__.'/ContainerLqp0pSr.legacy');

    return;
}

if (!\class_exists(phpDocumentor_KernelProdContainer::class, false)) {
    \class_alias(\ContainerLqp0pSr\phpDocumentor_KernelProdContainer::class, phpDocumentor_KernelProdContainer::class, false);
}

return new \ContainerLqp0pSr\phpDocumentor_KernelProdContainer([
    'container.build_hash' => 'Lqp0pSr',
    'container.build_id' => '8b0d4ef3',
    'container.build_time' => 1609536997,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerLqp0pSr');