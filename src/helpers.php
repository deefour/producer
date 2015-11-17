<?php

use Illuminate\Support\Collection;
use Deefour\Producer\Contracts\Producible;

if (!function_exists('produce')) {
    /**
     * Instantiate and return a resolvable wrapping the passed object.
     *
     * @param Producer|mixed $object
     * @param string $what
     *
     * @return Producible
     */
    function produce($object, $what)
    {
        $collection = null;

        if ($object instanceof Collection) {
            $collection = $object->all();
        } elseif (is_array($object)) {
            $collection = $object;
        }

        if (!is_null($collection)) {
            $objects = [];

            foreach ($collection as $item) {
                $objects[] = produce($item, $what);
            }

            if ($object instanceof Collection) {
                return new Collection($objects);
            }

            return $objects;
        }

        return $object->produce($what);
    }
}
