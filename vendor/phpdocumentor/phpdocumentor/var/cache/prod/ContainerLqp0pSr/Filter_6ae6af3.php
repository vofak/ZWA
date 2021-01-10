<?php

namespace ContainerLqp0pSr;

include_once \dirname(__DIR__, 4).'/src/phpDocumentor/Descriptor/Filter/Filter.php';
class Filter_6ae6af3 extends \phpDocumentor\Descriptor\Filter\Filter implements \ProxyManager\Proxy\VirtualProxyInterface
{
    private $valueHoldera2c02 = null;
    private $initializerdda02 = null;
    private static $publicPropertiesa717c = [
        
    ];
    public function filter(\phpDocumentor\Descriptor\Filter\Filterable $descriptor) : ?\phpDocumentor\Descriptor\Filter\Filterable
    {
        $this->initializerdda02 && ($this->initializerdda02->__invoke($valueHoldera2c02, $this, 'filter', array('descriptor' => $descriptor), $this->initializerdda02) || 1) && $this->valueHoldera2c02 = $valueHoldera2c02;
        return $this->valueHoldera2c02->filter($descriptor);
    }
    public static function staticProxyConstructor($initializer)
    {
        static $reflection;
        $reflection = $reflection ?? new \ReflectionClass(__CLASS__);
        $instance   = $reflection->newInstanceWithoutConstructor();
        \Closure::bind(function (\phpDocumentor\Descriptor\Filter\Filter $instance) {
            unset($instance->pipeline);
        }, $instance, 'phpDocumentor\\Descriptor\\Filter\\Filter')->__invoke($instance);
        $instance->initializerdda02 = $initializer;
        return $instance;
    }
    public function __construct(iterable $filters)
    {
        static $reflection;
        if (! $this->valueHoldera2c02) {
            $reflection = $reflection ?? new \ReflectionClass('phpDocumentor\\Descriptor\\Filter\\Filter');
            $this->valueHoldera2c02 = $reflection->newInstanceWithoutConstructor();
        \Closure::bind(function (\phpDocumentor\Descriptor\Filter\Filter $instance) {
            unset($instance->pipeline);
        }, $this, 'phpDocumentor\\Descriptor\\Filter\\Filter')->__invoke($this);
        }
        $this->valueHoldera2c02->__construct($filters);
    }
    public function & __get($name)
    {
        $this->initializerdda02 && ($this->initializerdda02->__invoke($valueHoldera2c02, $this, '__get', ['name' => $name], $this->initializerdda02) || 1) && $this->valueHoldera2c02 = $valueHoldera2c02;
        if (isset(self::$publicPropertiesa717c[$name])) {
            return $this->valueHoldera2c02->$name;
        }
        $realInstanceReflection = new \ReflectionClass('phpDocumentor\\Descriptor\\Filter\\Filter');
        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHoldera2c02;
            $backtrace = debug_backtrace(false, 1);
            trigger_error(
                sprintf(
                    'Undefined property: %s::$%s in %s on line %s',
                    $realInstanceReflection->getName(),
                    $name,
                    $backtrace[0]['file'],
                    $backtrace[0]['line']
                ),
                \E_USER_NOTICE
            );
            return $targetObject->$name;
        }
        $targetObject = $this->valueHoldera2c02;
        $accessor = function & () use ($targetObject, $name) {
            return $targetObject->$name;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = & $accessor();
        return $returnValue;
    }
    public function __set($name, $value)
    {
        $this->initializerdda02 && ($this->initializerdda02->__invoke($valueHoldera2c02, $this, '__set', array('name' => $name, 'value' => $value), $this->initializerdda02) || 1) && $this->valueHoldera2c02 = $valueHoldera2c02;
        $realInstanceReflection = new \ReflectionClass('phpDocumentor\\Descriptor\\Filter\\Filter');
        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHoldera2c02;
            $targetObject->$name = $value;
            return $targetObject->$name;
        }
        $targetObject = $this->valueHoldera2c02;
        $accessor = function & () use ($targetObject, $name, $value) {
            $targetObject->$name = $value;
            return $targetObject->$name;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = & $accessor();
        return $returnValue;
    }
    public function __isset($name)
    {
        $this->initializerdda02 && ($this->initializerdda02->__invoke($valueHoldera2c02, $this, '__isset', array('name' => $name), $this->initializerdda02) || 1) && $this->valueHoldera2c02 = $valueHoldera2c02;
        $realInstanceReflection = new \ReflectionClass('phpDocumentor\\Descriptor\\Filter\\Filter');
        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHoldera2c02;
            return isset($targetObject->$name);
        }
        $targetObject = $this->valueHoldera2c02;
        $accessor = function () use ($targetObject, $name) {
            return isset($targetObject->$name);
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = $accessor();
        return $returnValue;
    }
    public function __unset($name)
    {
        $this->initializerdda02 && ($this->initializerdda02->__invoke($valueHoldera2c02, $this, '__unset', array('name' => $name), $this->initializerdda02) || 1) && $this->valueHoldera2c02 = $valueHoldera2c02;
        $realInstanceReflection = new \ReflectionClass('phpDocumentor\\Descriptor\\Filter\\Filter');
        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHoldera2c02;
            unset($targetObject->$name);
            return;
        }
        $targetObject = $this->valueHoldera2c02;
        $accessor = function () use ($targetObject, $name) {
            unset($targetObject->$name);
            return;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $accessor();
    }
    public function __clone()
    {
        $this->initializerdda02 && ($this->initializerdda02->__invoke($valueHoldera2c02, $this, '__clone', array(), $this->initializerdda02) || 1) && $this->valueHoldera2c02 = $valueHoldera2c02;
        $this->valueHoldera2c02 = clone $this->valueHoldera2c02;
    }
    public function __sleep()
    {
        $this->initializerdda02 && ($this->initializerdda02->__invoke($valueHoldera2c02, $this, '__sleep', array(), $this->initializerdda02) || 1) && $this->valueHoldera2c02 = $valueHoldera2c02;
        return array('valueHoldera2c02');
    }
    public function __wakeup()
    {
        \Closure::bind(function (\phpDocumentor\Descriptor\Filter\Filter $instance) {
            unset($instance->pipeline);
        }, $this, 'phpDocumentor\\Descriptor\\Filter\\Filter')->__invoke($this);
    }
    public function setProxyInitializer(\Closure $initializer = null) : void
    {
        $this->initializerdda02 = $initializer;
    }
    public function getProxyInitializer() : ?\Closure
    {
        return $this->initializerdda02;
    }
    public function initializeProxy() : bool
    {
        return $this->initializerdda02 && ($this->initializerdda02->__invoke($valueHoldera2c02, $this, 'initializeProxy', array(), $this->initializerdda02) || 1) && $this->valueHoldera2c02 = $valueHoldera2c02;
    }
    public function isProxyInitialized() : bool
    {
        return null !== $this->valueHoldera2c02;
    }
    public function getWrappedValueHolderValue() : ?object
    {
        return $this->valueHoldera2c02;
    }
}

if (!\class_exists('Filter_6ae6af3', false)) {
    \class_alias(__NAMESPACE__.'\\Filter_6ae6af3', 'Filter_6ae6af3', false);
}
