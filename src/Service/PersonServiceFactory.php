<?php
/**
 * Created by PhpStorm.
 * User: figo-007
 * Date: 2016/12/22
 * Time: 13:43:45
 */
namespace ApigilitySocial\Service;

use Zend\ServiceManager\ServiceManager;

class PersonServiceFactory
{
    public function __invoke(ServiceManager $services)
    {
        return new PersonService($services);
    }
}