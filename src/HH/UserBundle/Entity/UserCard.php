<?php

namespace HH\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserCard
 *
 * @ORM\Table(name="user_card", indexes={@ORM\Index(name="CardNumber", columns={"cardNumber"}), @ORM\Index(name="UserId", columns={"userId"})})
 * @ORM\Entity
 */
class UserCard
{
    /**
     * @var integer
     *
     * @ORM\Column(name="cardId", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $cardid;

    /**
     * @var integer
     *
     * @ORM\Column(name="userId", type="integer", nullable=false)
     */
    private $userid;

    /**
     * @var integer
     *
     * @ORM\Column(name="cardNumber", type="integer", nullable=false)
     */
    private $cardnumber;

    /**
     * @var string
     *
     * @ORM\Column(name="cardValue", type="string", length=21, nullable=false)
     */
    private $cardvalue;


    /**
     * Set userid
     *
     * @param integer $userid
     * @return UserCard
     */
    public function setUserId($userid)
    {
        $this->userid = $userid;

        return $this;
    }

    /**
     * Get userid
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->userid;
    }

    /**
     * Set cardnumber
     *
     * @param integer $cardnumber
     * @return UserCard
     */
    public function setCardNumber($cardnumber)
    {
        $this->cardnumber = $cardnumber;

        return $this;
    }

    /**
     * Get cardnumber
     *
     * @return integer
     */
    public function getCardNumber()
    {
        return $this->cardnumber;
    }

    /**
     * Set cardvalue
     *
     * @param string $cardvalue
     * @return UserCard
     */
    public function setCardValue($cardvalue)
    {
        $this->cardvalue = $cardvalue;

        return $this;
    }

    /**
     * Get cardvalue
     *
     * @return string
     */
    public function getCardValue()
    {
        return $this->cardvalue;
    }

    /**
     * Get cardid
     *
     * @return integer
     */
    public function getCardId()
    {
        return $this->cardid;
    }
}
