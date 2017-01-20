<?php
/**
 * Created by PhpStorm.
 * User: figo-007
 * Date: 2016/12/22
 * Time: 13:44:15
 */
namespace ApigilitySocial\Service;

use Zend\ServiceManager\ServiceManager;

class FriendServiceFactory
{
    public function __invoke(ServiceManager $services)
    {
        return new FriendService($services);
    }
}