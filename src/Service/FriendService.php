<?php
/**
 * Created by PhpStorm.
 * User: figo-007
 * Date: 2016/12/22
 * Time: 13:44:06
 */
namespace ApigilitySocial\Service;

use ApigilityUser\Service\UserService;
use Zend\ServiceManager\ServiceManager;
use Zend\Hydrator\ClassMethods as ClassMethodsHydrator;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrineToolPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrinePaginatorAdapter;
use ApigilitySocial\DoctrineEntity;

class FriendService
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

    public function __construct(ServiceManager $services)
    {
        $this->classMethodsHydrator = new ClassMethodsHydrator();
        $this->em = $services->get('Doctrine\ORM\EntityManager');
        $this->userService = $services->get('ApigilityUser\Service\UserService');
        $this->personService = $services->get('ApigilitySocial\Service\PersonService');
    }

    /**
     * 创建好友
     *
     * @param $data
     * @return DoctrineEntity\Friend
     * @throws \Exception
     */
    public function createFriend($data)
    {
        $friend = new DoctrineEntity\Friend();

        $friend->setStatus(DoctrineEntity\Friend::STATUS_NORMAL);
        $friend->setCreateTime(new \DateTime());

        if (isset($data->name)) $friend->setName($data->name);

        if (isset($data->person_id)) $friend->setPerson($this->personService->getPerson($data->person_id));
        else throw new \Exception('没有指定要添加的目标好友', 500);

        if (isset($data->user_id)) $friend->setUser($this->userService->getUser($data->user_id));
        else throw new \Exception('没有指定好友所属用户', 500);

        // 防止重复加好友
        if ($this->getFriends((object)[
            'user_id'=>$data->user_id,
            'person_id'=>$data->person_id
        ])->count()) throw new \Exception('该好友已存在你的好友列表中', 409);


        $this->em->persist($friend);
        $this->em->flush();

        return $friend;
    }

    /**
     * 获取好友
     *
     * @param $friend_id
     * @return DoctrineEntity\Friend
     * @throws \Exception
     */
    public function getFriend($friend_id)
    {
        $friend = $this->em->find('ApigilitySocial\DoctrineEntity\Friend', $friend_id);
        if (empty($friend)) throw new \Exception('好友不存在', 404);
        else return $friend;
    }

    /**
     * 获取好友列表
     *
     * @param $params
     * @return DoctrinePaginatorAdapter
     */
    public function getFriends($params)
    {
        $qb = new QueryBuilder($this->em);
        $qb->select('f')->from('ApigilitySocial\DoctrineEntity\Friend', 'f');

        $where = '';

        if (isset($params->user_id)) {
            $qb->innerJoin('f.user', 'u');
            if (!empty($where)) $where .= ' AND ';
            $where .= 'u.id = :user_id';
        }

        if (isset($params->person_id)) {
            $qb->innerJoin('f.person', 'p');
            if (!empty($where)) $where .= ' AND ';
            $where .= 'p.id = :person_id';
        }

        if (isset($params->status)) {
            if (!empty($where)) $where .= ' AND ';
            $where .= 'f.status = :status';
        }

        if (!empty($where)) {
            $qb->where($where);
            if (isset($params->user_id)) $qb->setParameter('user_id', $params->user_id);
            if (isset($params->person_id)) $qb->setParameter('person_id', $params->person_id);
            if (isset($params->status)) $qb->setParameter('status', $params->status);
        }

        $doctrine_paginator = new DoctrineToolPaginator($qb->getQuery());
        return new DoctrinePaginatorAdapter($doctrine_paginator);
    }

    /**
     * 修改好友
     *
     * @param $friend_id
     * @param $data
     * @return DoctrineEntity\Friend
     * @throws \Exception
     */
    public function updateFriend($friend_id, $data)
    {
        $friend = $this->getFriend($friend_id);

        if (isset($data->name)) $friend->setName($data->name);
        if (isset($data->status)) $friend->setStatus($data->status);

        $this->em->flush();

        return $friend;
    }

    /**
     * 删除好友
     *
     * @param $friend_id
     * @return bool
     * @throws \Exception
     */
    public function deleteFriend($friend_id)
    {
        $friend = $this->getFriend($friend_id);

        $this->em->remove($friend);
        $this->em->flush();

        return true;
    }
}