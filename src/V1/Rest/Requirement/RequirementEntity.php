<?php
namespace ApigilitySocial\V1\Rest\Requirement;

use ApigilityAddress\DoctrineEntity\Address;
use ApigilityAddress\V1\Rest\Address\AddressEntity;
use ApigilityCatworkFoundation\Base\ApigilityObjectStorageAwareEntity;
use ApigilitySocial\DoctrineEntity\Person;
use ApigilitySocial\V1\Rest\Person\PersonEntity;
use ApigilityUser\DoctrineEntity\IncomeLevel;
use ApigilityUser\DoctrineEntity\Occupation;
use ApigilityUser\V1\Rest\IncomeLevel\IncomeLevelEntity;
use ApigilityUser\V1\Rest\Occupation\OccupationEntity;

class RequirementEntity extends ApigilityObjectStorageAwareEntity
{
    /**
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * 交友条件的所有者，个人对象
     *
     * @ManyToOne(targetEntity="Person")
     * @JoinColumn(name="person_id", referencedColumnName="id")
     */
    protected $person;

    /**
     * 性别
     *
     * @Column(type="smallint", nullable=true)
     */
    protected $sex;

    /**
     * 最小年龄
     *
     * @Column(type="smallint", nullable=true)
     */
    protected $age_min;

    /**
     * 最大年龄
     *
     * @Column(type="smallint", nullable=true)
     */
    protected $age_max;

    /**
     * 最小身高
     *
     * @Column(type="smallint", nullable=true)
     */
    protected $stature_min;

    /**
     * 最大身高
     *
     * @Column(type="smallint", nullable=true)
     */
    protected $stature_max;

    /**
     * 学历
     *
     * @Column(type="smallint", nullable=true)
     */
    protected $education;

    /**
     * 感情状态
     *
     * @Column(type="smallint", nullable=true)
     */
    protected $emotion;

    /**
     * 星座
     *
     * @Column(type="smallint", nullable=true)
     */
    protected $zodiac;

    /**
     * 生肖
     *
     * @Column(type="smallint", nullable=true)
     */
    protected $chinese_zodiac;

    /**
     * 居住地址
     *
     * @OneToOne(targetEntity="ApigilityAddress\DoctrineEntity\Address")
     * @JoinColumn(name="residence_address_id", referencedColumnName="id")
     */
    protected $residence_address;

    /**
     * 户口地址
     *
     * @OneToOne(targetEntity="ApigilityAddress\DoctrineEntity\Address")
     * @JoinColumn(name="census_register_address_id", referencedColumnName="id")
     */
    protected $census_register_address;

    /**
     * 职业
     *
     * @ManyToOne(targetEntity="ApigilityUser\DoctrineEntity\Occupation")
     * @JoinColumn(name="occupation_id", referencedColumnName="id")
     */
    protected $occupation;

    /**
     * 收入等级
     *
     * @ManyToOne(targetEntity="ApigilityUser\DoctrineEntity\IncomeLevel")
     * @JoinColumn(name="income_level_id", referencedColumnName="id")
     */
    protected $income_level;


    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setPerson($person)
    {
        $this->person = $person;
        return $this;
    }

    public function getPerson()
    {
        if ($this->person instanceof Person) return (object)[];
        else return $this->person;
    }

    public function setSex($sex)
    {
        $this->sex = $sex;
        return $this;
    }

    public function getSex()
    {
        return $this->sex;
    }

    public function setAgeMin($age_min)
    {
        $this->age_min = $age_min;
        return $this;
    }

    public function getAgeMin()
    {
        return $this->age_min;
    }

    public function setAgeMax($age_max)
    {
        $this->age_max = $age_max;
        return $this;
    }

    public function getAgeMax()
    {
        return $this->age_max;
    }

    public function setStatureMin($stature_min)
    {
        $this->stature_min = $stature_min;
        return $this;
    }

    public function getStatureMin()
    {
        return $this->stature_min;
    }

    public function setStatureMax($stature_max)
    {
        $this->stature_max = $stature_max;
        return $this;
    }

    public function getStatureMax()
    {
        return $this->stature_max;
    }

    public function setEducation($education)
    {
        $this->education = $education;
        return $this;
    }

    public function getEducation()
    {
        return $this->education;
    }

    public function setEmotion($emotion)
    {
        $this->emotion = $emotion;
        return $this;
    }

    public function getEmotion()
    {
        return $this->emotion;
    }

    public function setZodiac($zodiac)
    {
        $this->zodiac = $zodiac;
        return $this;
    }

    public function getZodiac()
    {
        return $this->zodiac;
    }

    public function setChineseZodiac($chinese_zodiac)
    {
        $this->chinese_zodiac = $chinese_zodiac;
        return $this;
    }

    public function getChineseZodiac()
    {
        return $this->chinese_zodiac;
    }

    public function setOccupation($occupation)
    {
        $this->occupation = $occupation;
        return $this;
    }

    public function getOccupation()
    {
        if ($this->occupation instanceof Occupation) return $this->hydrator->extract(new OccupationEntity($this->occupation));
        else return $this->occupation;
    }

    public function setIncomeLevel($income_level)
    {
        $this->income_level = $income_level;
        return $this;
    }

    public function getIncomeLevel()
    {
        if ($this->income_level instanceof IncomeLevel) return $this->hydrator->extract(new IncomeLevelEntity($this->income_level));
        else return $this->income_level;
    }

    public function setResidenceAddress($residence_address)
    {
        $this->residence_address = $residence_address;
        return $this;
    }

    public function getResidenceAddress()
    {
        if ($this->residence_address instanceof Address) return $this->hydrator->extract(new AddressEntity($this->residence_address));
        else return $this->residence_address;
    }

    public function setCensusRegisterAddress($census_register_address)
    {
        $this->census_register_address = $census_register_address;
        return $this;
    }

    public function getCensusRegisterAddress()
    {
        if ($this->census_register_address instanceof Address) return $this->hydrator->extract(new AddressEntity($this->census_register_address));
        else return $this->census_register_address;
    }
}
