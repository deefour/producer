<?php

namespace Deefour\Producer\Contracts;

use Deefour\Producer\Exceptions\NotProducibleException;

interface Producer
{
    /**
     * Custom resolver class resolution.
     *
     * @throws NotProducibleException
     * @param string $what
     * @return Producible
     */
    public function produce($what);

    /**
     * Determine the source from which producibles should be resolved.
     */
    public function resolvable();
}
