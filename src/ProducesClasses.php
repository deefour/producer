<?php

namespace Deefour\Producer;

use Deefour\Producer\Contracts\Producible;

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
     * @inheritdoc
     */
    public function resolvable()
    {
        return $this;
    }
}
