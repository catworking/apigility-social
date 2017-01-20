<?php
namespace ApigilitySocial\V1\Rest\Requirement;

use ApigilityCatworkFoundation\Base\ApigilityObjectStorageAwareCollection;

class RequirementCollection extends ApigilityObjectStorageAwareCollection
{
    protected $itemType = RequirementEntity::class;
}
