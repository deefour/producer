<?php

namespace Deefour\Producer;

use ReflectionClass;
use Illuminate\Support\Pluralizer;

/**
 * A basic resolver. Maps class names like either
 *
 *  - App\Podcast
 *  - App\Models\Podcast
 *
 * to (when resolving a 'serializer')
 *
 *  - App\Serializers\PodcastSerializer
 */
trait ResolvesProducibles
{
    /**
     * @inheritdoc
     */
    public function resolve($what)
    {
        if (class_exists($what)) {
            return $what;
        }

        $resolvable = method_exists($this, 'resolvable') ? $this->resolvable() : $this;
        $reflection = new ReflectionClass($resolvable);
        $suffix     = ucfirst($what);
        $namespace  = Pluralizer::plural($suffix);

        $fqcn = join(
            '\\',
            [
                preg_replace('#Models?\\\#', '', $reflection->getNamespaceName()),
                $namespace,
                $reflection->getShortName() . $suffix
            ]
        );

        return $fqcn;
    }
}
