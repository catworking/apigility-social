<?php
namespace ApigilitySocial\V1\Rest\Friend;

use ApigilityCatworkFoundation\Base\ApigilityObjectStorageAwareCollection;

class FriendCollection extends ApigilityObjectStorageAwareCollection
{
    protected $itemType = FriendEntity::class;
}
