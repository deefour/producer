<?php

namespace Deefour\Producer\Stubs;

use Deefour\Producer\Stubs\Serializers\AnnouncementSerializer;

class Newsletter extends Model
{
    public function resolve($what)
    {
        return AnnouncementSerializer::class;
    }
}
