<?php
/**
 * Created by PhpStorm.
 * User: figo-007
 * Date: 2016/12/6
 * Time: 15:04
 */
namespace ApigilitySocial;

use ApigilitySocial\Service\PersonService;
use ApigilityVIP\DoctrineEntity\Contract;
use ApigilityVIP\DoctrineEntity\Status;
use ApigilityVIP\Service\ContractService;
use Doctrine\ORM\EntityManager;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\EventManager\EventInterface;
use Zend\ServiceManager\ServiceManager;

class PersonContractListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    private $services;

    /**
     * @var EntityManager
     */
    protected $em;

    public function __construct(ServiceManager $services)
    {
        $this->services = $services;
        $this->em = $services->get('Doctrine\ORM\EntityManager');
    }

    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(ContractService::EVENT_CONTRACT_PAYED, [$this, 'updatePerson'], $priority);
    }

    public function updatePerson(EventInterface $e)
    {
        $params = $e->getParams();
        $contract = $this->getContract($params['contract']);

        // 更新社交人的会员状态
        $person = $this->getPersonService()->getPersonByUserId($contract->getUser()->getId());

        // 更新原则：同级身份合约，延长时间；异级的身份合约覆盖时间。
        if ($person->getVipStatus() instanceof Status &&
            $person->getVipExpireTime() instanceof \DateTime &&
            $person->getVipExpireTime()->getTimestamp() > (new \DateTime())->getTimestamp()) {

            if ($person->getVipStatus()->getId() === $contract->getService()->getStatus()->getId()) {
                // 先修改合约生效时间
                $contract = $this->getContractService()->updateContract($contract->getId(), (object)[
                    'effective_time'=>$person->getVipExpireTime()->getTimestamp()+1
                ]);

                // 延长时间
                $person->setVipExpireTime($contract->getExpireTime());
            } else {
                // 覆盖身份、时间
                $person->setVipStatus($contract->getService()->getStatus());
                $person->setVipExpireTime($contract->getExpireTime());
            }
        } else {
            // 第一次成为会员
            $person->setVipStatus($contract->getService()->getStatus());
            $person->setVipExpireTime($contract->getExpireTime());
        }

        $this->em->flush();
    }

    /**
     * @param $contract
     * @return Contract
     */
    private function getContract($contract)
    {
        return $contract;
    }

    /**
     * @return PersonService
     */
    private function getPersonService()
    {
        return $this->services->get('ApigilitySocial\Service\PersonService');
    }

    /**
     * @return ContractService
     */
    private function getContractService()
    {
        return $this->services->get('ApigilityVIP\Service\ContractService');
    }
}