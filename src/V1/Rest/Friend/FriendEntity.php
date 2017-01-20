<?php
namespace ApigilitySocial\V1\Rest\Friend;

use ApigilityCatworkFoundation\Base\ApigilityObjectStorageAwareEntity;
use ApigilitySocial\DoctrineEntity\Person;
use ApigilitySocial\V1\Rest\Person\PersonEntity;
use ApigilityUser\DoctrineEntity\User;
use ApigilityUser\V1\Rest\User\UserEntity;

class FriendEntity extends ApigilityObjectStorageAwareEntity
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * 好友名
     *
     * @Column(type="string", length=50, nullable=true)
     */
    protected $name;

    /**
     * 好友的所有者，ApigilityUser组件的User对象
     *
     * @ManyToOne(targetEntity="ApigilityUser\DoctrineEntity\User")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * 好友的个人对象
     *
     * @ManyToOne(targetEntity="Person")
     * @JoinColumn(name="person_id", referencedColumnName="id")
     */
    protected $person;

    /**
     * 添加时间
     *
     * @Column(type="datetime", nullable=false)
     */
    protected $create_time;

    /**
     * 好友状态
     *
     * @Column(type="smallint", nullable=true)
     */
    protected $status;

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }

    public function getUser()
    {
        if ($this->user instanceof User) return $this->hydrator->extract(new UserEntity($this->user, $this->serviceManager));
        else return $this->user;
    }

    public function setPerson($person)
    {
        $this->person = $person;
        return $this;
    }

    public function getPerson()
    {
        if ($this->person instanceof Person) return $this->hydrator->extract(new PersonEntity($this->person, $this->serviceManager));
        else return $this->person;
    }

    public function setCreateTime($create_time)
    {
        $this->create_time = $create_time;
        return $this;
    }

    public function getCreateTime()
    {
        if ($this->create_time instanceof \DateTime) return $this->create_time->getTimestamp();
        else return $this->create_time;
    }

    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }
}
