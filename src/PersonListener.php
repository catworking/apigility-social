<?php
/**
 * Created by PhpStorm.
 * User: figo-007
 * Date: 2016/12/6
 * Time: 15:04
 */
namespace ApigilitySocial;

use ApigilitySocial\Service\PersonService;
use ApigilityUser\Service\IdentityService;
use ApigilityUser\Service\UserService;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\EventManager\EventInterface;
use Zend\ServiceManager\ServiceManager;

class PersonListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    private $services;

    /**
     * @var IdentityService
     */
    private $identityService;

    public function __construct(ServiceManager $services)
    {
        $this->services = $services;
    }

    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(UserService::EVENT_USER_CREATED, [$this, 'createPerson'], $priority);
    }

    public function createPerson(EventInterface $e)
    {
        $params = $e->getParams();

        // 创建社交人对象
        $this->identityService = $this->services->get('ApigilityUser\Service\IdentityService');
        $identity = $this->identityService->getIdentity($params['user']->getId());
        if ($identity->getType() == 'social_person') {
            $this->getPersonService()->createPerson((object)[
                'user_id'=>$params['user']->getId()
            ]);
        }
    }

    /**
     * @return PersonService
     */
    private function getPersonService()
    {
        return $this->services->get('ApigilitySocial\Service\PersonService');
    }
}