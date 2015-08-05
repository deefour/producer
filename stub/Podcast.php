<?php

namespace Deefour\Producer\Stubs;

use Deefour\Producer\Contracts\Producer;
use Illuminate\Support\Fluent;
use Deefour\Producer\ProducesClasses;

class Podcast extends Fluent implements Producer
{
    use ProducesClasses;
}
