<?php

namespace BW\UserBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class UserRepository extends EntityRepository implements UserProviderInterface
{
    public function loadUserByUsername($username)
    {
        $qb = $this->createQueryBuilder('u');
        $q = $qb
            ->select('u')
            ->addSelect('r')
            ->leftJoin('u.roles', 'r')
            ->where($qb->expr()->orX(
                $qb->expr()->eq('u.username', ':username'),
                $qb->expr()->eq('u.email', ':username')
            ))
            ->setParameter('username', $username)
            ->getQuery()
        ;

        try {
            // The Query::getSingleResult() method throws an exception
            // if there is no record matching the criteria.
            $user = $q->getSingleResult();
        } catch (NoResultException $e) {
            throw new UsernameNotFoundException(sprintf(
                'Пользователь с логином или email "%s" не найден.',
                $username
            ), 0, $e);
        }

        return $user;
    }
    
    public function isEmailExists($email)
    {
        $qb = $this->createQueryBuilder('u');
        $count = $qb
            ->select($qb->expr()->count('u.id'))
            ->where($qb->expr()->eq('u.email', ':email'))
            ->setParameter('email', $email)
            ->getQuery()
            ->getSingleScalarResult()
        ;

        return (boolean)$count;
    }
    
    public function isUsernameExists($username)
    {
        $qb = $this->createQueryBuilder('u');
        $count = $qb
            ->select($qb->expr()->count('u.id'))
            ->where($qb->expr()->eq('u.username', ':username'))
            ->setParameter('username', $username)
            ->getQuery()
            ->getSingleScalarResult()
        ;

        return (boolean)$count;
    }

    public function refreshUser(UserInterface $user)
    {
        /** @var \BW\UserBundle\Entity\User $user */
        $class = get_class($user);
        if ( ! $this->supportsClass($class)) {
            throw new UnsupportedUserException(sprintf(
                'Instances of "%s" are not supported.',
                $class
            ));
        }

        return $this->find($user->getId());
    }

    public function supportsClass($class)
    {
        return false
            || $this->getEntityName() === $class
            || is_subclass_of($this->getEntityName(), $class)
        ;
    }
}