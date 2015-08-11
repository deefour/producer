<?php

namespace Deefour\Producer\Exceptions;

use Deefour\Producer\Contracts\Producer;

class NotProducibleException extends \Exception
{
    /**
     * The FQCN of the failed 'producible' class.
     *
     * @var string
     */
    protected $producible;

    /**
     * The resolver.
     *
     * @var Producer
     */
    protected $object;

    /**
     * Constructor.
     *
     * @param string $producible
     * @param Producer $object
     * @param string $message
     */
    public function __construct($producible, Producer $object, $message = '')
    {
      $this->producible = $producible;
      $this->object     = $object;

      parent::__construct($message ?: $this->message());
    }

    /**
     * {@inheritdoc}
     */
    protected function message()
    {
        return sprintf(
            'Unable to find producible [%s] class for [%s]',
            $this->producible,
            get_class($this->object)
        );
    }
}
