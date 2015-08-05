<?php

namespace Deefour\Producer;

use Deefour\Producer\Contracts\Resolvable;

trait ProducesClasses
{
    /**
     * @inheritdoc
     */
    public function produce($what)
    {
      $factory = new Factory();

      return $factory->makeOrFail($this, $what);
    }

    /**
     * Magic resolver.
     *
     * @param string $method
     * @param array $args
     * @return Resolvable
     */
    public function __call($method, $args)
    {
        if (strpos($method, 'produce') === 0) {
            return $this->produce(
                lcfirst(preg_replace('/^produce/', '', $method))
            );
        }

        return parent::__call($method, $args);
    }
}
