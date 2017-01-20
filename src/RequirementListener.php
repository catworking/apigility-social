<?php
/**
 * Created by PhpStorm.
 * User: figo-007
 * Date: 2016/12/6
 * Time: 15:04
 */
namespace ApigilitySocial;

use ApigilitySocial\Service\PersonService;
use ApigilitySocial\Service\RequirementService;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\EventManager\EventInterface;
use Zend\ServiceManager\ServiceManager;

class RequirementListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    private $services;

    public function __construct(ServiceManager $services)
    {
        $this->services = $services;
    }

    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(PersonService::EVENT_PERSON_CREATED, [$this, 'createRequirement'], $priority);
    }

    public function createRequirement(EventInterface $e)
    {
        $params = $e->getParams();

        // 创建社交人的交友条件数据
        $this->getRequirementService()->createRequirement((object)[
            'person_id'=>$params['person']->getId()
        ]);
    }

    /**
     * @return RequirementService
     */
    private function getRequirementService()
    {
        return $this->services->get('ApigilitySocial\Service\RequirementService');
    }
}