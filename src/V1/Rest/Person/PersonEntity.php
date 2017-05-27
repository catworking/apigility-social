<?php
namespace ApigilitySocial\V1\Rest\Person;

use ApigilityCatworkFoundation\Base\ApigilityObjectStorageAwareEntity;
use ApigilitySocial\DoctrineEntity\Requirement;
use ApigilitySocial\V1\Rest\Requirement\RequirementEntity;
use ApigilityUser\DoctrineEntity\User;
use ApigilityUser\V1\Rest\User\UserEntity;
use ApigilityVIP\DoctrineEntity\Status;
use ApigilityVIP\V1\Rest\Status\StatusEntity;
use Zend\Math\Rand;

class PersonEntity extends ApigilityObjectStorageAwareEntity
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * 形象照
     *
     * @Column(type="string", length=255, nullable=false)
     */
    protected $appearance_image;

    /**
     * 个性封面
     *
     * @Column(type="string", length=255, nullable=false)
     */
    protected $cover_image;

    /**
     * 文章的所有者，ApigilityUser组件的User对象
     *
     * @ManyToOne(targetEntity="ApigilityUser\DoctrineEntity\User")
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
        if (empty($this->appearance_image)) return $this->appearance_image;
        else return $this->renderUriToUrl($this->appearance_image);
    }

    public function setCoverImage($cover_image)
    {
        $this->cover_image = $cover_image;
        return $this;
    }

    public function getCoverImage()
    {
        if (empty($this->cover_image)) return $this->cover_image;
        else return $this->renderUriToUrl($this->cover_image);
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

    public function setRequirement($requirement)
    {
        $this->requirement = $requirement;
        return $this;
    }

    public function getRequirement()
    {
        if ($this->requirement instanceof Requirement) return $this->hydrator->extract(new RequirementEntity($this->requirement, $this->serviceManager));
        else return $this->requirement;
    }

    public function getVip()
    {
        if ($this->vip_expire_time instanceof \DateTime && $this->vip_expire_time->getTimestamp() > (new \DateTime())->getTimestamp()) {
            return true;
        } else {
            return false;
        }
    }

    public function setVipStatus($vip_status)
    {
        $this->vip_status = $vip_status;
        return $this;
    }

    public function getVipStatus()
    {
        if ($this->vip_status instanceof Status) return $this->hydrator->extract(new StatusEntity($this->vip_status));
        else return $this->vip_status;
    }

    public function setVipExpireTime($vip_expire_time)
    {
        $this->vip_expire_time = $vip_expire_time;
        return $this;
    }

    public function getVipExpireTime()
    {
        if ($this->vip_expire_time instanceof \DateTime) return $this->vip_expire_time->getTimestamp();
        return $this->vip_expire_time;
    }

    /**
     * 随机显示在线状态(在线概率90%)
     */
    public function getOnline()
    {
        return (boolean)$this->user->getTokens();
    }
}
