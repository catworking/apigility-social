<?php
namespace ApigilitySocial\V1\Rest\Friend;

class FriendResourceFactory
{
    public function __invoke($services)
    {
        return new FriendResource($services);
    }
}
