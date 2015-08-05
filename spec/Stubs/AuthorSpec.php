<?php

namespace spec\Deefour\Producer\Stubs;

use Deefour\Producer\Exceptions\NotProducibleException;
use Deefour\Producer\Stubs\Author;
use PhpSpec\ObjectBehavior;

class AuthorSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Author::class);
    }

    public function it_throws_exception_for_unresolvableß()
    {
        $this->shouldThrow(NotProducibleException::class)->duringProduce('presenter');
    }
}
