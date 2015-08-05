<?php

namespace Deefour\Producer;

use Deefour\Producer\Contracts\Producer;
use Deefour\Producer\Contracts\Producible;
use Deefour\Producer\Exceptions\NotProducibleException;
use ReflectionClass;

class Factory
{
    public function resolve(Producer $object, $what)
    {
      if (method_exists($object, 'resolve')) {
        return $object->resolve($what);
      }

      return get_class($object) . ucfirst($what);
    }

    /**
     * Derives a 'producible' class name for the passed object. Null is returned
     * if the object fails to be resolved.
     *
     * @param Producer $object
     * @param string $what
     * @return Producible
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
     * Derives a 'producible' class for the passed object. If the producible does
     * not exist an exception is thrown.
     *
     * @throws NotProducibleException
     * @param Producer $object
     * @param string $what
     * @return Producible
     */
    public function makeOrFail(Producer $object, $what)
    {
        $producible = $this->resolve($object, $what);

        if (!is_a($producible, Producible::class, true)) {
            throw new NotProducibleException($producible, $object);
        }

        if (method_exists($object, 'make')) {
            return $object->make($producible);
        }

        return new $producible($object);
    }
}
