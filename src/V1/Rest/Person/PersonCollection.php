<?php
namespace ApigilitySocial\V1\Rest\Person;

use ApigilityCatworkFoundation\Base\ApigilityObjectStorageAwareCollection;

class PersonCollection extends ApigilityObjectStorageAwareCollection
{
    protected $itemType = PersonEntity::class;
}
