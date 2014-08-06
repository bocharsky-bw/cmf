<?php

namespace BW\UserBundle\Entity;

use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class User
 * @package BW\UserBundle\Entity
 */
class User implements AdvancedUserInterface, \Serializable
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string $username
     */
    private $username = '';

    /**
     * @var string $password
     */
    private $password = '';

    /**
     * @var string $salt
     */
    private $salt = '';

    /**
     * @var string $email
     */
    private $email = '';

    /**
     * Whether User is enabled
     *
     * @var boolean $enabled
     */
    private $enabled = false;

    /**
     * Whether user e-mail is confirmed
     *
     * @var boolean $confirmed
     */
    private $confirmed = false;

    /**
     * @var \DateTime $created
     */
    private $created;
    
    /**
     * @var \DateTime $updated
     */
    private $updated;

    /**
     * @var string $hash
     */
    private $hash = '';

    /**
     * @var string $facebookId
     */
    private $facebookId = '';

    /**
     * @var string $googleId
     */
    private $googleId = '';

    /**
     * @var string $vkId
     */
    private $vkId = '';

    /**
     * @var ArrayCollection $roles
     */
    private $roles;

    /**
     * @var Profile $profile
     */
    private $profile;


    /**
     * The constructor
     */
    public function __construct()
    {
        $this->salt = md5(uniqid(null, true));
        $this->hash = md5(uniqid(null, true));
        $this->created = new \DateTime;
        $this->updated = new \DateTime;
        $this->roles = new ArrayCollection();
    }

    
    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    /**
     * Generate random 13-symbols user password, unique for every method call
     *
     * @return \BW\UserBundle\Entity\User
     */
    public function generateRandomPassword()
    {
        $this->password = uniqid(null, false);
        
        return $this;
    }

    /**
     * Generate hash for automatic activation link
     *
     * @return \BW\UserBundle\Entity\User
     */
    public function generateRandomHash()
    {
        $this->hash = md5(uniqid(null, true));
        
        return $this;
    }

    /**
     * Generate date of update
     * 
     * ORM\PreUpdate
     * @return \BW\UserBundle\Entity\User
     */
    public function generateUpdatedDate()
    {
        $this->updated = new \DateTime;
        
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }

    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
        ) = unserialize($serialized);
    }


    /* SETTERS / GETTERS */

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;
    
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Whether is User enabled
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return User
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    
        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean 
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Is confirmed
     *
     * @return boolean
     */
    public function isConfirmed()
    {
        return $this->confirmed;
    }

    /**
     * Set confirmed
     *
     * @param boolean $confirmed
     * @return User
     */
    public function setConfirmed($confirmed)
    {
        $this->confirmed = $confirmed;

        return $this;
    }

    /**
     * Get confirmed
     *
     * @return boolean
     */
    public function getConfirmed()
    {
        return $this->confirmed;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return User
     */
    public function setCreated($created)
    {
        $this->created = $created;
    
        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return User
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    
        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set hash
     *
     * @param string $hash
     * @return User
     */
    public function setHash($hash)
    {
        $this->hash = $hash;
    
        return $this;
    }

    /**
     * Get hash
     *
     * @return string 
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Set facebookId
     *
     * @param mixed $facebookId
     * @return User
     */
    public function setFacebookId($facebookId)
    {
        $this->facebookId = $facebookId;
    
        return $this;
    }

    /**
     * Get facebookId
     *
     * @return string 
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }

    /**
     * Set googleId
     *
     * @param mixed $googleId
     * @return User
     */
    public function setGoogleId($googleId)
    {
        $this->googleId = $googleId;

        return $this;
    }

    /**
     * Get googleId
     *
     * @return string 
     */
    public function getGoogleId()
    {
        return $this->googleId;
    }

    /**
     * Set vkId
     *
     * @param string $vkId
     * @return User
     */
    public function setVkId($vkId)
    {
        $this->vkId = $vkId;

        return $this;
    }

    /**
     * Get vkId
     *
     * @return string 
     */
    public function getVkId()
    {
        return $this->vkId;
    }

    /**
     * Add roles
     *
     * @param \BW\UserBundle\Entity\Role $roles
     * @return User
     */
    public function addRole(Role $roles)
    {
        $this->roles[] = $roles;

        return $this;
    }

    /**
     * Remove roles
     *
     * @param \BW\UserBundle\Entity\Role $roles
     */
    public function removeRole(Role $roles)
    {
        $this->roles->removeElement($roles);
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return $this->roles->toArray();
    }

    /**
     * Get Doctrine ArrayCollection of Roles
     *
     * @return ArrayCollection
     */
    public function getRolesCollection()
    {
        return $this->roles;
    }

    /**
     * Set profile
     *
     * @param \BW\UserBundle\Entity\Profile $profile
     * @return User
     */
    public function setProfile(Profile $profile = null)
    {
        $this->profile = $profile;

        return $this;
    }

    /**
     * Get profile
     *
     * @return \BW\UserBundle\Entity\Profile
     */
    public function getProfile()
    {
        return $this->profile;
    }
}
