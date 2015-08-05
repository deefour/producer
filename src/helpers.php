<?php

use Illuminate\Support\Collection;

if (!function_exists('resolve')) {
    /**
     * Instantiate and return a resolvable wrapping the passed object.
     *
     * @param Producer|mixed $object
     * @param string $what
     *
     * @return Deefour\Producer\Resolvable
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
                $objects[] = resolver($item, $what);
            }

            if ($object instanceof Collection) {
                return new Collection($objects);
            }

            return $objects;
        }

        return $object->produce($what);
    }
}
