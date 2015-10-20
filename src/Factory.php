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
     * {@inheritdoc}
     */
    public function resolve(Producer $object, $what)
    {
        $class = get_class($object);

        // implement a resolve() method on $object to customize behaviore
        if (method_exists($object, 'resolve') && ($result = $object->resolve($what)) !== false) {
            return $result;
        }

        return $class . ucfirst($what);
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
