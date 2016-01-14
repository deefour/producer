<?php

namespace Deefour\Producer\Stubs;

use Deefour\Producer\Contracts\Producer;
use Deefour\Producer\ProducesClasses;
use Deefour\Producer\ResolvesProducibles;
use Illuminate\Support\Fluent;

abstract class Model extends Fluent implements Producer
{
    use ProducesClasses, ResolvesProducibles;
}
