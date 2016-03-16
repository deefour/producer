<?php

namespace spec\Deefour\Producer\Stubs;

use Deefour\Producer\Stubs\Article;
use Deefour\Producer\Stubs\Serializers\ArticleSerializer;
use Deefour\Producer\Stubs\Presenters\ArticlePresenter;
use Deefour\Producer\Stubs\Presenters\FeaturedArticlePresenter;
use PhpSpec\ObjectBehavior;
use Deefour\Producer\Exceptions\NotProducibleException;

class ArticleSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Article::class);
    }

    public function it_resolves_names_types()
    {
        $this->produce('presenter')->shouldBeAnInstanceOf(ArticlePresenter::class);
        $this->produce('serializer')->shouldBeAnInstanceOf(ArticleSerializer::class);
    }

    public function it_resolves_custom_classes()
    {
        $this->produce(FeaturedArticlePresenter::class)->shouldBeAnInstanceOf(FeaturedArticlePresenter::class);
    }

    public function it_throws_exception_for_unknown_classes()
    {
        $this->shouldThrow(NotProducibleException::class)->duringProduce('unknown');
    }
}
