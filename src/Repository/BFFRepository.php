<?php

namespace App\Repository;

use App\Entity\BFF;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BFF|null find($id, $lockMode = null, $lockVersion = null)
 * @method BFF|null findOneBy(array $criteria, array $orderBy = null)
 * @method BFF[]    findAll()
 * @method BFF[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BFFRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BFF::class);
    }

    /**
     * @param $sender
     * @param $receiver
     * @return int|mixed|string
     *
     * Its verification to know if friend request twice
     */
    public function findIfIsFriend($sender, $receiver)
    {

        return $this->createQueryBuilder('b')
            ->andWhere('b.sender = :sender AND b.receiver = :receiver')
            ->setParameters([
                'sender' => $sender,
                'receiver' => $receiver,
            ])
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return BFF[] Returns an array of BFF objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BFF
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

}
