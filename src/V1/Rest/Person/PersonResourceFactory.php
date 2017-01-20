<?php
namespace ApigilitySocial\V1\Rest\Person;

class PersonResourceFactory
{
    public function __invoke($services)
    {
        return new PersonResource($services);
    }
}
