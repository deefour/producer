<?php

namespace Deefour\Producer\Contracts;

use Deefour\Producer\Contracts\Producer;
use Deefour\Producer\Contracts\Producible;
use Deefour\Producer\Exceptions\NotProducibleException;

interface ProductionFactory
{
    /**
     * Generate an FQCN for the '$what' (serializer, presenter, etc...) based on
     * the name of the Producer object passed.
     *
     * @param Producer $object
     * @param string $what
     * @return string
     */
    public function resolve(Producer $object, $what);

    /**
     * Derives a 'producible' class for the passed object. Null is returned if
     * the object fails to be resolved.
     *
     * @param Producer $object
     * @param string $what
     * @return Producible|null
     */
    public function make(Producer $object, $what);

    /**
     * Derives a 'producible' class for the passed object. If the producible does
     * not exist an exception is thrown.
     *
     * @throws NotProducibleException
     * @param Producer $object
     * @param string $what
     * @return Producible
     */
    public function makeOrFail(Producer $object, $what);
}
