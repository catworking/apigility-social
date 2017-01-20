<?php
/**
 * Created by PhpStorm.
 * User: figo-007
 * Date: 2016/12/22
 * Time: 13:43:25
 */
namespace ApigilitySocial\Service;

use ApigilityCatworkFoundation\Base\ApigilityEventAwareObject;
use ApigilityUser\Service\UserService;
use Zend\ServiceManager\ServiceManager;
use Zend\Hydrator\ClassMethods as ClassMethodsHydrator;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrineToolPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrinePaginatorAdapter;
use ApigilitySocial\DoctrineEntity;

class PersonService extends ApigilityEventAwareObject
{
    const EVENT_PERSON_CREATED = 'PersonService.EVENT_PERSON_CREATED';

    protected $classMethodsHydrator;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var UserService
     */
    protected $userService;

    public function __construct(ServiceManager $services)
    {
        $this->classMethodsHydrator = new ClassMethodsHydrator();
        $this->em = $services->get('Doctrine\ORM\EntityManager');
        $this->userService = $services->get('ApigilityUser\Service\UserService');
    }

    /**
     * 创建个人
     *
     * @param $data
     * @return DoctrineEntity\Person
     * @throws \Exception
     */
    public function createPerson($data)
    {
        $person = new DoctrineEntity\Person();

        if (isset($data->appearance_image)) $person->setAppearanceImage($data->appearance_image);
        if (isset($data->cover_image)) $person->setCoverImage($data->cover_image);

        if (isset($data->user_id)) $person->setUser($this->userService->getUser($data->user_id));
        else throw new \Exception('没有指定用户', 500);

        $this->em->persist($person);
        $this->em->flush();

        $this->getEventManager()->trigger(self::EVENT_PERSON_CREATED, $this, ['person' => $person]);

        return $person;
    }

    /**
     * 获取个人
     *
     * @param $person_id
     * @return DoctrineEntity\Person
     * @throws \Exception
     */
    public function getPerson($person_id)
    {
        $person = $this->em->find('ApigilitySocial\DoctrineEntity\Person', $person_id);
        if (empty($person)) throw new \Exception('个人数据不存在', 404);
        else return $person;
    }

    /**
     * 获取个人列表
     *
     * @param $params
     * @return DoctrinePaginatorAdapter
     */
    public function getPersons($params)
    {
        $qb = new QueryBuilder($this->em);
        $qb->select('p')->from('ApigilitySocial\DoctrineEntity\Person', 'p');

        $where = '';

        if (isset($params->user_id) ||
            isset($params->sex) ||
            isset($params->age_min) ||
            isset($params->age_max) ||
            isset($params->stature_min) ||
            isset($params->stature_max) ||
            isset($params->education) ||
            isset($params->emotion) ||
            isset($params->zodiac) ||
            isset($params->chinese_zodiac) ||
            isset($params->occupation) ||
            isset($params->income_level) ||
            isset($params->residence_address_province) ||
            isset($params->residence_address_city) ||
            isset($params->residence_address_district) ||
            isset($params->census_register_address_province) ||
            isset($params->census_register_address_city) ||
            isset($params->census_register_address_district))  $qb->innerJoin('p.user', 'u');

        if (isset($params->user_id)) {
            if (!empty($where)) $where .= ' AND ';
            $where .= 'u.id = :user_id';
        }

        if (isset($params->sex)) {
            if (!empty($where)) $where .= ' AND ';
            $where .= 'u.sex = :sex';
        }

        if (isset($params->age_min)) {
            if (!empty($where)) $where .= ' AND ';
            $where .= 'u.age >= :age_min';
        }

        if (isset($params->age_max)) {
            if (!empty($where)) $where .= ' AND ';
            $where .= 'u.age <= :age_max';
        }

        if (isset($params->stature_min)) {
            if (!empty($where)) $where .= ' AND ';
            $where .= 'u.stature >= :stature_min';
        }

        if (isset($params->stature_max)) {
            if (!empty($where)) $where .= ' AND ';
            $where .= 'u.stature <= :stature_max';
        }

        if (isset($params->education)) {
            if (!empty($where)) $where .= ' AND ';
            $where .= 'u.education >= :education';
        }

        if (isset($params->emotion)) {
            if (!empty($where)) $where .= ' AND ';
            $where .= 'u.emotion = :emotion';
        }

        if (isset($params->zodiac)) {
            if (!empty($where)) $where .= ' AND ';
            $where .= 'u.zodiac = :zodiac';
        }

        if (isset($params->chinese_zodiac)) {
            if (!empty($where)) $where .= ' AND ';
            $where .= 'u.chinese_zodiac = :chinese_zodiac';
        }

        if (isset($params->occupation)) {
            if (!empty($where)) $where .= ' AND ';
            $where .= 'u.occupation = :occupation';
        }

        if (isset($params->income_level)) {
            if (!empty($where)) $where .= ' AND ';
            $where .= 'u.income_level >= :income_level';
        }

        if (isset($params->residence_address_province) ||
            isset($params->residence_address_city) ||
            isset($params->residence_address_district)) $qb->innerJoin('u.residence_address', 'ra');

        if (isset($params->residence_address_province)) {
            $qb->innerJoin('ra.province', 'rap');
            if (!empty($where)) $where .= ' AND ';
            $where .= 'rap.id = :residence_address_province';
        }

        if (isset($params->residence_address_city)) {
            $qb->innerJoin('ra.city', 'rac');
            if (!empty($where)) $where .= ' AND ';
            $where .= 'rac.id = :residence_address_city';
        }

        if (isset($params->residence_address_district)) {
            $qb->innerJoin('ra.district', 'rad');
            if (!empty($where)) $where .= ' AND ';
            $where .= 'rad.id = :residence_address_district';
        }

        if (isset($params->census_register_address_province) ||
            isset($params->census_register_address_city) ||
            isset($params->census_register_address_district)) $qb->innerJoin('u.census_register_address', 'cra');

        if (isset($params->census_register_address_province)) {
            $qb->innerJoin('cra.province', 'crap');
            if (!empty($where)) $where .= ' AND ';
            $where .= 'crap.id = :census_register_address_province';
        }

        if (isset($params->census_register_address_city)) {
            $qb->innerJoin('cra.city', 'crac');
            if (!empty($where)) $where .= ' AND ';
            $where .= 'crac.id = :census_register_address_city';
        }

        if (isset($params->census_register_address_district)) {
            $qb->innerJoin('cra.district', 'crad');
            if (!empty($where)) $where .= ' AND ';
            $where .= 'crad.id = :census_register_address_district';
        }

        if (isset($params->vip)) {
            if (!empty($where)) $where .= ' AND ';
            $where .= 'p.vip_expire_time > :now';
        }

        if (!empty($where)) {
            $qb->where($where);

            if (isset($params->user_id)) $qb->setParameter('user_id', $params->user_id);
            if (isset($params->sex)) $qb->setParameter('sex', $params->sex);

            if (isset($params->age_min)) $qb->setParameter('age_min', $params->age_min);
            if (isset($params->age_max)) $qb->setParameter('age_max', $params->age_max);
            if (isset($params->stature_min)) $qb->setParameter('stature_min', $params->stature_min);
            if (isset($params->stature_max)) $qb->setParameter('stature_max', $params->stature_max);

            if (isset($params->education)) $qb->setParameter('education', $params->education);
            if (isset($params->emotion)) $qb->setParameter('emotion', $params->emotion);
            if (isset($params->zodiac)) $qb->setParameter('zodiac', $params->zodiac);
            if (isset($params->chinese_zodiac)) $qb->setParameter('chinese_zodiac', $params->chinese_zodiac);

            if (isset($params->occupation)) $qb->setParameter('occupation', $params->occupation);
            if (isset($params->income_level)) $qb->setParameter('income_level', $params->income_level);

            if (isset($params->residence_address_province))
                $qb->setParameter('residence_address_province', $params->residence_address_province);
            if (isset($params->residence_address_city))
                $qb->setParameter('residence_address_city', $params->residence_address_city);
            if (isset($params->residence_address_district))
                $qb->setParameter('residence_address_district', $params->residence_address_district);
            if (isset($params->census_register_address_province))
                $qb->setParameter('census_register_address_province', $params->census_register_address_province);
            if (isset($params->census_register_address_city))
                $qb->setParameter('census_register_address_city', $params->census_register_address_city);
            if (isset($params->census_register_address_district))
                $qb->setParameter('census_register_address_district', $params->census_register_address_district);

            if (isset($params->vip)) $qb->setParameter('now', new \DateTime());
        }

        $doctrine_paginator = new DoctrineToolPaginator($qb->getQuery());
        return new DoctrinePaginatorAdapter($doctrine_paginator);
    }

    /**
     * @param $user_id
     * @return DoctrineEntity\Person
     * @throws \Exception
     */
    public function getPersonByUserId($user_id)
    {
        $persons = $this->getPersons((object)['user_id'=>$user_id]);
        if ($persons->count()) {
            return $persons->getItems(0,1)[0];
        } else {
            throw new \Exception('社交人不存在', 404);
        }
    }

    /**
     * 修改个人
     *
     * @param $person_id
     * @param $data
     * @return DoctrineEntity\Person
     * @throws \Exception
     */
    public function updatePerson($person_id, $data)
    {
        $person = $this->getPerson($person_id);

        if (isset($data->appearance_image)) $person->setAppearanceImage($data->appearance_image);
        if (isset($data->cover_image)) $person->setCoverImage($data->cover_image);

        $this->em->flush();

        return $person;
    }

    /**
     * 删除个人
     *
     * @param $person_id
     * @return bool
     * @throws \Exception
     */
    public function deletePerson($person_id)
    {
        $person = $this->getPerson($person_id);

        $this->em->remove($person);
        $this->em->flush();

        return true;
    }
}