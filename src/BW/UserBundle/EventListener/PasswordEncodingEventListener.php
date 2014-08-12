<?php

namespace BW\UserBundle\EventListener;

use Symfony\Bridge\Monolog\Logger;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use BW\UserBundle\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class PasswordEncodingEventListener
 * @package BW\UserBundle\EventListener
 */
class PasswordEncodingEventListener
{

    /**
     * @var EncoderFactory
     */
    private $encoderFactory;

    /**
     * @var Logger
     */
    private $logger;


    /**
     * The constructor
     *
     * @param EncoderFactory $encoderFactory
     */
    public function __construct(EncoderFactory $encoderFactory, Logger $logger) {
        $this->encoderFactory = $encoderFactory;
        $this->logger = $logger;
        $this->logger->debug(sprintf(
            'Loaded event listener "%s".',
            __METHOD__
        ));
    }


    public function prePersist(LifecycleEventArgs $args) {
        $this->logger->debug(sprintf(
            'Notified event "prePersist" to listener "%s".',
            __METHOD__
        ));

        /** @var UserInterface $entity */
        $entity = $args->getEntity();
        //$em = $args->getEntityManager();

        if ($entity instanceof User) {
            // If new User hasn't password
            if ( ! $entity->getPassword()) {
                // Generate random password for security reasons
                $entity->setPassword(md5(uniqid(null, true)));
            }
            // Hash new User password
            $passwordHash = $this->encodePassword($entity, $entity->getPassword());
            $entity->setPassword($passwordHash);
        }
    }

    public function preUpdate(PreUpdateEventArgs $args) {
        $this->logger->debug(sprintf(
            'Notified event "preUpdate" to listener "%s".',
            __METHOD__
        ));

        /** @var UserInterface $entity */
        $entity = $args->getEntity();
        //$em = $args->getEntityManager();

        if ($entity instanceof User) {
            if ($args->hasChangedField('password')) {
                // If User password was changed
                if ($args->getNewValue('password')) {
                    // Hash new User password
                    $passwordHash = $this->encodePassword($entity, $entity->getPassword());
                    $args->setNewValue('password', $passwordHash);
                } else {
                    // or leave old password
                    $args->setNewValue('password', $args->getOldValue('password'));
                }
            }
        }
    }

    /**
     * The user password hash
     *
     * @param UserInterface $entity The User object that implemented UserInterface
     * @param $newPassword The new User password to encode
     * @return string Encoded password hash
     */
    public function encodePassword(UserInterface $entity, $newPassword) {
        $encoder = $this->encoderFactory->getEncoder($entity);
        $passwordHash = $encoder->encodePassword($newPassword, $entity->getSalt());

        return $passwordHash;
    }
}