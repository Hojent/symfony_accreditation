<?php

namespace AppBundle\Entity;

use Doctrine\DBAL\Types\DateType;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * UserProfile
 *
 * @ORM\Table(name="user_profile",
 *     options={"collate":"utf8mb4_general_ci", "charset":"utf8mb4", "engine":"InnoDB"})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserProfileRepository")
 * @UniqueEntity(fields="privatenum", message="Number already taken")
 */
class UserProfile
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * One UserProfile has One User.
     * @ORM\OneToOne(targetEntity="User", mappedBy="userprofile", cascade= {"persist", "remove"})
     *
     */
    private $userid;

    // user's data ******************************************************

    /**
     * @var string
     *
     * @ORM\Column(name="family", type="string", length=128, nullable=true)
     */
    protected $family;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=128, nullable=true)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="secondname", type="string", length=128, nullable=true)
     */
    protected $secondname;

    /**
     * @var DateType
     * @ORM\Column(name="databorn", type="string", nullable=true)
     */
    protected $databorn;

     /**
     * @var string
     * @ORM\Column(name="privatenum", type="string", length=128, unique=true, nullable=false)
     */
    protected $privatenum;

    /**
     * @var string
     *
     * @ORM\Column(name="passportnum", type="string",  nullable=false)
     */
    protected $passportnum;

    /**
     * @var DateType
     *
     * @ORM\Column(name="issuedata", type="string", nullable=true)
     */
    protected $issuedata;

    /**
     * @var string
     *
     * @ORM\Column(name="ruvd", type="string", length=256, nullable=true)
     */
    protected $ruvd;

    /**
     * @var string
     *
     * @ORM\Column(name="enddata", type="string", nullable=true)
     */
    protected $enddata;

    /**
     * @var string
     *
     * @ORM\Column(name="place", type="string", nullable=true)
     */
    protected $place;

    // user's contacts **************************************************

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", nullable=true)
     */
    protected $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", nullable=true)
     */
    protected $address;

    // user's files **************************************************

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="string", nullable=true)
     */
    private $photo;  //link to file

    /**
     * @var string
     *
     * @ORM\Column(name="application", type="string", nullable=true)
     */
    private $application;  //link to file   - application pdf file



    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set family
     *
     * @param string $family
     *
     * @return UserProfile
     */
    public function setFamily($family)
    {
        $this->family = $family;

        return $this;
    }

    /**
     * Get family
     *
     * @return string
     */
    public function getFamily()
    {
        return $this->family;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return UserProfile
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set secondname
     *
     * @param string $secondname
     *
     * @return UserProfile
     */
    public function setSecondname($secondname)
    {
        $this->secondname = $secondname;

        return $this;
    }

    /**
     * Get secondname
     *
     * @return string
     */
    public function getSecondname()
    {
        return $this->secondname;
    }

    /**
     * Set passportnum
     *
     * @param integer $passportnum
     *
     * @return UserProfile
     */
    public function setPassportnum($passportnum)
    {
        $this->passportnum = $passportnum;

        return $this;
    }

    /**
     * Get passportnum
     *
     * @return int
     */
    public function getPassportnum()
    {
        return $this->passportnum;
    }

    /**
     * Set privatenum
     *
     * @param integer $privatenum
     *
     * @return UserProfile
     */
    public function setPrivatenum($privatenum)
    {
        $this->privatenum = $privatenum;

        return $this;
    }

    /**
     * Get privatenum
     *
     * @return string
     */
    public function getPrivatenum()
    {
        return $this->privatenum;
    }

    /**
     * Set issuedata
     *
     * @param $issuedata
     *
     * @return UserProfile
     */
    public function setIssuedata($issuedata)
    {
        $this->issuedata = $issuedata;

        return $this;
    }

    /**
     * Get issuedata
     *
     * @return DateType
     */
    public function getIssuedata()
    {
        return $this->issuedata;
    }

    /**
     * Set enddata
     *
     * @param $enddata
     *
     * @return UserProfile
     */
    public function setEnddata($enddata)
    {
        $this->enddata = $enddata;

        return $this;
    }

    /**
     * Get enddata
     *
     */
    public function getEnddata()
    {
        return $this->enddata;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return UserProfile
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     */
    public function getPhone() :?string
    {
        return $this->phone;
    }

    /**
     * Set photo
     *
     * @param string $photo
     *
     * @return UserProfile
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set user
     * @param mixed
     */
    public function setUserid($userid)
    {
        $this->userid = $userid;
        return $this;
    }

    /**
     * Get user
     *
     * @return mixed
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return UserProfile
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }


    /**
     * Set ruvd
     *
     * @param string $ruvd
     *
     * @return UserProfile
     */
    public function setRuvd($ruvd)
    {
        $this->ruvd = $ruvd;

        return $this;
    }

    /**
     * Get ruvd
     *
     * @return string
     */
    public function getRuvd()
    {
        return $this->ruvd;
    }

    /**
     * @return string
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * @param string $place
     */
    public function setPlace(string $place)
    {
        $this->place = $place;
    }

    /**
     * @return string
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * @param string $application
     */
    public function setApplication(string $application)
    {
        $this->application = $application;
    }

    /**
     * @return DateType
     */
    public function getDataborn()
    {
        return $this->databorn;
    }

    /**
     * @param $databorn
     */
    public function setDataborn($databorn): void
    {
        $this->databorn = $databorn;
    }

    public function __toString()
    {
        if ($this->getFamily()) {
            return ($this->getName().' '.$this->getFamily());
        }
    }
}

