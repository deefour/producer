<?php

namespace Deefour\Producer\Stubs\Serializers;

use Deefour\Producer\Contracts\Producer;
use Deefour\Producer\Contracts\Producible;

class ArticleSerializer implements Producible
{
    protected $producer;

    public function __construct(Producer $producer)
    {
      $this->producer = $producer;
    }

    public function producer() {
        return $this->producer;
    }
}
