<?php

namespace spec\Deefour\Producer;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Deefour\Producer\Stubs\Article;
use Deefour\Producer\Stubs\Newsletter;
use Deefour\Producer\Stubs\Serializers\ArticleSerializer;
use Deefour\Producer\Stubs\Serializers\AnnouncementSerializer;
use Deefour\Producer\Stubs\Podcast;
use Deefour\Producer\Exceptions\NotProducibleException;

class FactorySpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Deefour\Producer\Factory');
    }

    public function it_should_provide_default_resolution()
    {
        $this->resolve(new Podcast(), 'serializer')
            ->shouldReturn('Deefour\Producer\Stubs\PodcastSerializer');
    }

    public function it_should_allow_custom_resolution()
    {
        $this->resolve(new Article(), 'serializer')->shouldReturn(ArticleSerializer::class);
    }

    public function it_should_instantiate_existing_producible()
    {
        $article    = new Article;
        $serializer = $this->make($article, 'serializer');

        $serializer->shouldBeAnInstanceOf(ArticleSerializer::class);
        $serializer->producer()->shouldReturn($article);
    }

    public function it_should_allow_custom_producible_instantiation()
    {
        $this->make(new Newsletter(), 'serializer')->shouldReturnAnInstanceOf(AnnouncementSerializer::class);
    }

    public function it_should_null_on_nonexistent_producible()
    {
        $this->make(new Podcast(), 'serializer')->shouldReturn(null);
    }

    public function it_should_fail_loudly_on_nonexistent_producible()
    {
        $this->shouldThrow(NotProducibleException::class)->duringMakeOrFail(new Podcast(), 'serializer');
    }
}
