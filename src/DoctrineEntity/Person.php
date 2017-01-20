<?php
/**
 * Created by PhpStorm.
 * User: figo-007
 * Date: 2016/12/22
 * Time: 12:07:14
 */
namespace ApigilitySocial\DoctrineEntity;

use ApigilityVIP\DoctrineEntity\Status;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\Common\Collections\ArrayCollection;
use ApigilityUser\DoctrineEntity\User;

/**
 * Class Person
 * @package ApigilitySocial\DoctrineEntity
 * @Entity @Table(name="apigilitysocial_person")
 */
class Person
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * 形象照
     *
     * @Column(type="string", length=255, nullable=true)
     */
    protected $appearance_image;

    /**
     * 个性封面
     *
     * @Column(type="string", length=255, nullable=true)
     */
    protected $cover_image;

    /**
     * ApigilityUser组件的User对象
     *
     * @OneToOne(targetEntity="ApigilityUser\DoctrineEntity\User")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * 交友条件
     *
     * @OneToOne(targetEntity="Requirement", mappedBy="person")
     */
    protected $requirement;

    /**
     * ApigilityVIP组件的Status身份对象
     *
     * @ManyToOne(targetEntity="ApigilityVIP\DoctrineEntity\Status")
     * @JoinColumn(name="status_id", referencedColumnName="id")
     */
    protected $vip_status;

    /**
     * VIP身份失效时间
     *
     * @Column(type="datetime", nullable=true)
     */
    protected $vip_expire_time;

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setAppearanceImage($appearance_image)
    {
        $this->appearance_image = $appearance_image;
        return $this;
    }

    public function getAppearanceImage()
    {
        return $this->appearance_image;
    }

    public function setCoverImage($cover_image)
    {
        $this->cover_image = $cover_image;
        return $this;
    }

    public function getCoverImage()
    {
        return $this->cover_image;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    public function setRequirement($requirement)
    {
        $this->requirement = $requirement;
        return $this;
    }

    /**
     * @return Requirement
     */
    public function getRequirement()
    {
        return $this->requirement;
    }

    public function setVipStatus($vip_status)
    {
        $this->vip_status = $vip_status;
        return $this;
    }

    /**
     * @return Status
     */
    public function getVipStatus()
    {
        return $this->vip_status;
    }

    public function setVipExpireTime($vip_expire_time)
    {
        $this->vip_expire_time = $vip_expire_time;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getVipExpireTime()
    {
        return $this->vip_expire_time;
    }
}