<?php

namespace Deefour\Producer\Facades;

/**
 * @see \Deefour\Producer\Factory
 */
class Producer extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'producer';
    }
}
