<?php

namespace Deefour\Producer;

use Deefour\Producer\Contracts\Producer;
use Deefour\Producer\Contracts\Producible;
use Deefour\Producer\Contracts\ProductionFactory;
use Deefour\Producer\Exceptions\NotProducibleException;
use ReflectionClass;

class Factory implements ProductionFactory
{
    /**
     * Static cache of resolved class names.
     *
     * @var array
     */
    static protected $resolutionCache = [];

    /**
     * {@inheritdoc}
     */
    public function resolve(Producer $object, $what)
    {
      $class = get_class($object);

      if (!array_key_exists($class, static::$resolutionCache)) {
          static::$resolutionCache[$class] = [];
      }

      // pull from cache
      if (isset(static::$resolutionCache[$class][$what])) {
          return static::$resolutionCache[$class][$what];
      }

      // implement a resolve() method on $object to customize behaviore
      if (method_exists($object, 'resolve') && ($result = $object->resolve($what)) !== false) {
          static::$resolutionCache[$class][$what] = $result;
      } else {
          static::$resolutionCache[$class][$what] = $class . ucfirst($what);
      }

      // default behavior
      return static::$resolutionCache[$class][$what];
    }

    /**
     * {@inheritdoc}
     */
    public function make(Producer $object, $what)
    {
        try {
            return $this->makeOrFail($object, $what);
        } catch (NotProducibleException $e) {
            return null;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function makeOrFail(Producer $object, $what)
    {
        $producible = $this->resolve($object, $what);

        if (!is_a($producible, Producible::class, true)) {
            throw new NotProducibleException($producible, $object);
        }

        // implement a make() method on $object to customize behaviore
        if (method_exists($object, 'make') && ($result = $object->make($producible)) !== false) {
            return $result;
        }

         // default behavior
        return new $producible($object);
    }
}
