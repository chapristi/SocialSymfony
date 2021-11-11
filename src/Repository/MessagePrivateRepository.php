<?php

namespace App\Repository;

use App\Entity\MessagePrivate;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MessagePrivate|null find($id, $lockMode = null, $lockVersion = null)
 * @method MessagePrivate|null findOneBy(array $criteria, array $orderBy = null)
 * @method MessagePrivate[]    findAll()
 * @method MessagePrivate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessagePrivateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MessagePrivate::class);
    }
    public function getMessages( $sender ,  $receiver)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.receiver = :receiver AND m.sender = :sender OR m.receiver = :sender AND m.sender = :receiver ')
            ->setParameters([
                "receiver" => $receiver,
                "sender" => $sender,
            ])
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return MessagePrivate[] Returns an array of MessagePrivate objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MessagePrivate
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

}
