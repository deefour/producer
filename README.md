# Producer

[![Build Status](https://travis-ci.org/deefour/producer.svg)](https://travis-ci.org/deefour/producer)
[![Packagist Version](http://img.shields.io/packagist/v/deefour/producer.svg)](https://packagist.org/packages/deefour/producer)
[![Code Climate](https://codeclimate.com/github/deefour/producer/badges/gpa.svg)](https://codeclimate.com/github/deefour/producer)
[![License](https://poser.pugx.org/deefour/producer/license)](https://packagist.org/packages/deefour/producer)

A small class factory.

## Getting Started

Run the following to add Producer to your project's `composer.json`. See [Packagist](https://packagist.org/packages/deefour/producer) for specific versions.

```bash
composer require deefour/producer
```

**`>=PHP5.5.0` is required.**

## Overview

A `Producer` is a class that resolves the FQCN of related `Producible` classes. The `Factory` accepts a `Producer` and "type", and can instantiate a concrete `Producible` class based on the resolved FQCN returned.

## Producers and Producibles

The production factory only accepts classes that implement `Deefour\Producer\Contracts\Producer`. An exception will be thrown if the resolved class does not implement `Deefour\Producer\Contracts\Producible`.

Given the following classes

```php
use Deefour\Producer\Contracts\Producer;
use Deefour\Producer\Contracts\Producible;

class Podcast implements Producer
{
    // ...
}

class PodcastPolicy implements Producible
{
    // ...
}

class PodcastScope implements Producible
{
    // ...
}
```

the production factory can produce an instance of each producible above when given a podcast and "type".


```php
use Deefour\Producer\Factory;

$podcast = new Podcast();
$factory = new Factory();

$factory->resolve($podcast, 'policy'); //=> 'PodcastPolicy`
$factory->resolve($podcast, 'scope'); //=> 'PodcastScope`

$factory->make($podcast, 'policy'); //=> instance of PodcastPolicy
```

### Resolving Producibles

The default producible resolver on the produciton factory looks like this

```php
get_class($producer) . ucfirst($type)
```

This can be customized by implementing a `resolve()` method on the producer passed into the factory.

```php
use Deefour\Producer\Contracts\Producer;

class Podcast implements Producer
{
    public function resolve($type)
    {
        // return FQCN string here
    }
}
```

This `deefour/producer` package also comes with a more opinionated resolver at `Deefour\Producer\ResolvesProducibles`.

```php
namespace App;

use Deefour\Producer\ResolvesProducibles;
use Deefour\Producer\Contracts\Producer;

class Podcast implements Producer
{
    use ResolvesProducibles;
}
```

this will pluralize the "type" passed in and append that to the namespace of the producer doing the class resolution.

```php
use App\Podcast;
use Deefour\Producer\Factory;

$podcast = new Podcast();
$factory = new Factory();

$factory->resolve($podcast, 'policy'); //=> 'App\Policies\PodcastPolicy`
```

### Making Producibles

The default producible instantiator on the production factory looks like this

```php
new $producible($producer);
```

This can be customized by implementing a `make()` method on the producer passed into the factory.

```php
use Deefour\Producer\Contracts\Producer;

class Podcast implements Producer
{
    public function make($producible)
    {
        // instantiate the passed $producible (an FQCN)
    }
}
```

**Note:** The `Deefour\Producer\ResolvesProducibles` trait does **not** implement the `make()` method.

## Contribute

- Issue Tracker: https://github.com/deefour/producer/issues
- Source Code: https://github.com/deefour/producer

## Changelog

#### 1.0.0 - October 7, 2015

 - Release 1.0.0.

#### 0.1.1 - August 8, 2015

 - Added `ProductionFactory` interface to allow more lenient type-hinting within other packages.
 - Docblock cleanup.

#### 0.1.0 - August 4, 2015

 - Initial release.

## License

Copyright (c) 2015 [Jason Daly](http://www.deefour.me) ([deefour](https://github.com/deefour)). Released under the [MIT License](http://deefour.mit-license.org/).
