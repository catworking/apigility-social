<?php
/**
 * Created by PhpStorm.
 * User: figo-007
 * Date: 2016/12/24
 * Time: 17:54:35
 */
namespace ApigilitySocial\Service;

use Zend\ServiceManager\ServiceManager;

class RequirementServiceFactory
{
    public function __invoke(ServiceManager $services)
    {
        return new RequirementService($services);
    }
}