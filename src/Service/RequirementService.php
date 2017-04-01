<?php
/**
 * Created by PhpStorm.
 * User: figo-007
 * Date: 2016/12/24
 * Time: 17:54:18
 */
namespace ApigilitySocial\Service;

use ApigilityAddress\Service\AddressService;
use ApigilitySocial\DoctrineEntity\Requirement;
use ApigilityUser\DoctrineEntity\User;
use ApigilityUser\Service\IncomeLevelService;
use ApigilityUser\Service\OccupationService;
use ApigilityUser\Service\UserService;
use Zend\ServiceManager\ServiceManager;
use Zend\Hydrator\ClassMethods as ClassMethodsHydrator;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrineToolPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrinePaginatorAdapter;
use ApigilitySocial\DoctrineEntity;

class RequirementService
{
    protected $classMethodsHydrator;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * @var PersonService
     */
    protected $personService;

    /**
     * @var OccupationService
     */
    protected $occupationService;

    /**
     * @var IncomeLevelService
     */
    protected $incomeLevelService;

    /**
     * @var AddressService
     */
    protected $addressService;

    public function __construct(ServiceManager $services)
    {
        $this->classMethodsHydrator = new ClassMethodsHydrator();
        $this->em = $services->get('Doctrine\ORM\EntityManager');
        $this->userService = $services->get('ApigilityUser\Service\UserService');
        $this->personService = $services->get('ApigilitySocial\Service\PersonService');
        $this->occupationService = $services->get('ApigilityUser\Service\OccupationService');
        $this->incomeLevelService = $services->get('ApigilityUser\Service\IncomeLevelService');
        $this->addressService = $services->get('ApigilityAddress\Service\AddressService');
    }

    /**
     * 创建交友条件
     *
     * @param $data
     * @return DoctrineEntity\Requirement
     * @throws \Exception
     */
    public function createRequirement($data)
    {
        $requirement = new DoctrineEntity\Requirement();

        $this->hydrateRequirementData($requirement, $data);

        if (isset($data->person_id)) $requirement->setPerson($this->personService->getPerson($data->person_id));
        else throw new \Exception('没有指定所属个人', 500);

        $this->em->persist($requirement);
        $this->em->flush();

        return $requirement;
    }

    /**
     * 获取交友条件
     *
     * @param $requirement_id
     * @return DoctrineEntity\Requirement
     * @throws \Exception
     */
    public function getRequirement($requirement_id)
    {
        $requirement = $this->em->find('ApigilitySocial\DoctrineEntity\Requirement', $requirement_id);
        if (empty($requirement)) throw new \Exception('交友条件不存在', 404);
        else return $requirement;
    }

    /**
     * 获取交友条件列表
     *
     * @param $params
     * @return DoctrinePaginatorAdapter
     */
    public function getRequirements($params)
    {
        $qb = new QueryBuilder($this->em);
        $qb->select('r')->from('ApigilitySocial\DoctrineEntity\Requirement', 'r');

        $doctrine_paginator = new DoctrineToolPaginator($qb->getQuery());
        return new DoctrinePaginatorAdapter($doctrine_paginator);
    }

    /**
     * 修改交友条件
     *
     * @param $requirement_id
     * @param $data
     * @return Requirement
     * @throws \Exception
     */
    public function updateRequirement($requirement_id, $data)
    {
        $requirement = $this->getRequirement($requirement_id);

        $this->hydrateRequirementData($requirement, $data);

        $this->em->flush();

        return $requirement;
    }

    /**
     * 删除交友条件
     *
     * @param $requirement_id
     * @return bool
     */
    public function deleteRequirement($requirement_id)
    {
        $requirement = $this->getRequirement($requirement_id);

        $this->em->remove($requirement);
        $this->em->flush();

        return true;
    }

    /**
     * @param Requirement $requirement
     * @param $data
     */
    private function hydrateRequirementData(Requirement $requirement, $data)
    {
        if (property_exists ($data, 'sex')) {
            if ($data->sex === 0) $requirement->setSex(null);
            else $requirement->setSex($data->sex);
        }

        if (property_exists ($data, 'age_min')) {
            if ($data->age_min === 0) $requirement->setAgeMin(null);
            else $requirement->setAgeMin($data->age_min);
        }

        if (property_exists ($data, 'age_max')) {
            if ($data->age_max === 0) $requirement->setAgeMax(null);
            else $requirement->setAgeMax($data->age_max);
        }

        if (property_exists ($data, 'stature_min')) {
            if ($data->stature_min === 0) $requirement->setStatureMin(null);
            else $requirement->setStatureMin($data->stature_min);
        }

        if (property_exists ($data, 'stature_max')) {
            if ($data->stature_max === 0) $requirement->setStatureMax(null);
            else $requirement->setStatureMax($data->stature_max);
        }


        if (property_exists ($data, 'education')) {
            if ($data->education === 0) $requirement->setEducation(null);
            else $requirement->setEducation($data->education);
        }

        if (property_exists ($data, 'emotion')) {
            if ($data->emotion === 0) $requirement->setEmotion(null);
            else $requirement->setEmotion($data->emotion);
        }

        if (property_exists ($data, 'zodiac')) {
            if ($data->zodiac === 0) $requirement->setZodiac(null);
            else $requirement->setZodiac($data->zodiac);
        }

        if (property_exists ($data, 'chinese_zodiac')) {
            if ($data->chinese_zodiac === 0) $requirement->setChineseZodiac(null);
            else $requirement->setChineseZodiac($data->chinese_zodiac);
        }


        if (property_exists ($data, 'income_level')) {
            if ($data->income_level === 0) $requirement->setIncomeLevel(null);
            else $requirement->setIncomeLevel($this->incomeLevelService->getIncomeLevel($data->income_level));
        }

        if (property_exists ($data, 'occupation')) {
            if ($data->occupation === 0) $requirement->setOccupation(null);
            else  $requirement->setOccupation($this->occupationService->getOccupation($data->occupation));
        }

        if (property_exists ($data, 'residence_address')) {
            if ($data->residence_address === 0) $requirement->setResidenceAddress(null);
            else $requirement->setResidenceAddress($this->addressService->getAddress($data->residence_address));
        }

        if (property_exists ($data, 'census_register_address')) {
            if ($data->census_register_address === 0) $requirement->setCensusRegisterAddress(null);
            else $requirement->setCensusRegisterAddress($this->addressService->getAddress($data->census_register_address));
        }
    }
}