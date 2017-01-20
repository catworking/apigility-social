<?php
namespace ApigilitySocial\V1\Rest\Requirement;

class RequirementResourceFactory
{
    public function __invoke($services)
    {
        return new RequirementResource($services);
    }
}
